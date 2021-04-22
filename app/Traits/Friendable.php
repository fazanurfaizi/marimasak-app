<?php

namespace App\Traits;

use App\Models\User\Friendship;
use App\Models\User\FriendGroup;
use App\Enum\FriendStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;

trait Friendable {

    public function befriend(Model $recipient) {

        if (!$this->canBefriend($recipient)) {
            return false;
        }

        $friendship = (new Friendship)->fillRecipient($recipient)->fill([
            'status' => FriendStatus::PENDING,
        ]);

        $this->friends()->save($friendship);

        Event::fire('friendships.sent', [$this, $recipient]);

        return $friendship;
    }

    public function unfriend(Model $recipient) {
        $deleted = $this->findFriendship($recipient)->delete();

        Event::fire('friendships.cancelled', [$this, $recipient]);

        return $deleted;
    }

    public function hasFriendRequestFrom(Model $recipient) {
        return $this->findFriendship($recipient)
            ->whereSender($recipient)
            ->whereStatus(FriendStatus::PENDING)
            ->exists();
    }

    public function hasSentFriendRequestTo(Model $recipient) {
        return Friendship::whereRecipient($recipient)
            ->whereSender($this)
            ->whereStatus(FriendStatus::PENDING)
            ->exists();
    }

    public function isFriendWith(Model $recipient) {
        return $this->findFriendship($recipient)
            ->where('status', FriendStatus::ACCEPTED)
            ->exists();
    }

    public function acceptFriendRequest(Model $recipient) {
        $updated = $this->findFriendship($recipient)->whereRecipient($this)->update([
            'status' => FriendStatus::ACCEPTED,
        ]);

        Event::fire('friendships.accepted', [$this, $recipient]);

        return $updated;
    }

    public function denyFriendRequest(Model $recipient) {
        $updated = $this->findFriendship($recipient)->whereRecipient($this)->update([
            'status' => FriendStatus::DENIED,
        ]);

        Event::fire('friendships.denied', [$this, $recipient]);

        return $updated;
    }

    public function groupFriend(Model $friend, $groupSlug) {
        $friendship       = $this->findFriendship($friend)->whereStatus(FriendStatus::ACCEPTED)->first();
        $groupsAvailable = config('friendships.groups', []);

        if (!isset($groupsAvailable[$groupSlug]) || empty($friendship)) {
            return false;
        }

        $group = $friendship->groups()->firstOrCreate([
            'friendship_id' => $friendship->id,
            'group_id'      => $groupsAvailable[$groupSlug],
            'friend_id'     => $friend->getKey(),
            'friend_type'   => $friend->getMorphClass(),
        ]);

        return $group->wasRecentlyCreated;

    }

    public function ungroupFriend(Model $friend, $groupSlug = ''){
        $friendship       = $this->findFriendship($friend)->first();
        $groupsAvailable = config('friendships.groups', []);

        if (empty($friendship)) {
            return false;
        }

        $where = [
            'friendship_id' => $friendship->id,
            'friend_id'     => $friend->getKey(),
            'friend_type'   => $friend->getMorphClass(),
        ];

        if ('' !== $groupSlug && isset($groupsAvailable[$groupSlug])) {
            $where['group_id'] = $groupsAvailable[$groupSlug];
        }

        $result = $friendship->groups()->where($where)->delete();

        return $result;

    }

    public function blockFriend(Model $recipient) {
        if (!$this->isBlockedBy($recipient)) {
            $this->findFriendship($recipient)->delete();
        }

        $friendship = (new Friendship)->fillRecipient($recipient)->fill([
            'status' => FriendStatus::BLOCKED,
        ]);

        $this->friends()->save($friendship);

        Event::fire('friendships.blocked', [$this, $recipient]);

        return $friendship;
    }

    public function unblockFriend(Model $recipient) {
        $deleted = $this->findFriendship($recipient)->whereSender($this)->delete();

        Event::fire('friendships.unblocked', [$this, $recipient]);

        return $deleted;
    }

    public function getFriendship(Model $recipient) {
        return $this->findFriendship($recipient)->first();
    }

    public function getAllFriendships($groupSlug = '') {
        return $this->findFriendships(null, $groupSlug)->get();
    }

    public function getPendingFriendships($groupSlug = '') {
        return $this->findFriendships(FriendStatus::PENDING, $groupSlug)->get();
    }

    public function getAcceptedFriendships($groupSlug = '') {
        return $this->findFriendships(FriendStatus::ACCEPTED, $groupSlug)->get();
    }

    public function getDeniedFriendships() {
        return $this->findFriendships(FriendStatus::DENIED)->get();
    }

    public function getBlockedFriendships() {
        return $this->findFriendships(FriendStatus::BLOCKED)->get();
    }

    public function hasBlocked(Model $recipient) {
        return $this->friends()->whereRecipient($recipient)->whereStatus(FriendStatus::BLOCKED)->exists();
    }

    public function isBlockedBy(Model $recipient) {
        return $recipient->hasBlocked($this);
    }

    public function getFriendRequests() {
        return Friendship::whereRecipient($this)->whereStatus(FriendStatus::PENDING)->get();
    }

    public function getFriends($perPage = 0, $groupSlug = '') {
        return $this->getOrPaginate($this->getFriendsQueryBuilder($groupSlug), $perPage);
    }

    public function getMutualFriends(Model $other, $perPage = 0) {
        return $this->getOrPaginate($this->getMutualFriendsQueryBuilder($other), $perPage);
    }

    public function getMutualFriendsCount($other) {
        return $this->getMutualFriendsQueryBuilder($other)->count();
    }

    public function getFriendsOfFriends($perPage = 0) {
        return $this->getOrPaginate($this->friendsOfFriendsQueryBuilder(), $perPage);
    }

    public function getFriendsCount($groupSlug = '') {
        $friendsCount = $this->findFriendships(FriendStatus::ACCEPTED, $groupSlug)->count();
        return $friendsCount;
    }

    public function canBefriend($recipient) {
        if ($this->hasBlocked($recipient)) {
            $this->unblockFriend($recipient);
            return true;
        }

        if ($friendship = $this->getFriendship($recipient)) {
            if ($friendship->status != FriendStatus::DENIED) {
                return false;
            }
        }
        return true;
    }

    private function findFriendship(Model $recipient) {
        return Friendship::betweenModels($this, $recipient);
    }

    private function findFriendships($status = null, $groupSlug = '') {

        $query = Friendship::where(function ($query) {
            $query->where(function ($q) {
                $q->whereSender($this);
            })->orWhere(function ($q) {
                $q->whereRecipient($this);
            });
        })->whereGroup($this, $groupSlug);

        if (!is_null($status)) {
            $query->where('status', $status);
        }

        return $query;
    }

    private function getFriendsQueryBuilder($groupSlug = '') {

        $friendships = $this->findFriendships(FriendStatus::ACCEPTED, $groupSlug)
            ->get(['sender_id', 'recipient_id']);

        $recipients  = $friendships->pluck('recipient_id')->all();
        $senders     = $friendships->pluck('sender_id')->all();

        return $this->where('id', '!=', $this->getKey())
            ->whereIn('id', array_merge($recipients, $senders));
    }

    private function getMutualFriendsQueryBuilder(Model $other) {
        $user1['friendships'] = $this->findFriendships(FriendStatus::ACCEPTED)->get(['sender_id', 'recipient_id']);
        $user1['recipients'] = $user1['friendships']->pluck('recipient_id')->all();
        $user1['senders'] = $user1['friendships']->pluck('sender_id')->all();

        $user2['friendships'] = $other->findFriendships(FriendStatus::ACCEPTED)->get(['sender_id', 'recipient_id']);
        $user2['recipients'] = $user2['friendships']->pluck('recipient_id')->all();
        $user2['senders'] = $user2['friendships']->pluck('sender_id')->all();

        $mutualFriendships = array_unique(
                                array_intersect(
                                    array_merge($user1['recipients'], $user1['senders']),
                                    array_merge($user2['recipients'], $user2['senders'])
                                )
                            );

        return $this->whereNotIn('id', [$this->getKey(), $other->getKey()])
            ->whereIn('id', $mutualFriendships);
    }

    private function friendsOfFriendsQueryBuilder($groupSlug = '') {
        $friendships = $this->findFriendships(FriendStatus::ACCEPTED)
            ->get(['sender_id', 'recipient_id']);

        $recipients = $friendships->pluck('recipient_id')->all();
        $senders = $friendships->pluck('sender_id')->all();

        $friendIds = array_unique(array_merge($recipients, $senders));


        $fofs = Friendship::where('status', FriendStatus::ACCEPTED)
                    ->where(function ($query) use ($friendIds) {
                        $query->where(function ($q) use ($friendIds) {
                            $q->whereIn('sender_id', $friendIds);
                        })->orWhere(function ($q) use ($friendIds) {
                            $q->whereIn('recipient_id', $friendIds);
                        });
                    })
                    ->whereGroup($this, $groupSlug)
                    ->get(['sender_id', 'recipient_id']);

        $fofIds = array_unique(
            array_merge($fofs->pluck('sender_id')->all(), $fofs->pluck('recipient_id')->all())
        );

        return $this->whereIn('id', $fofIds)->whereNotIn('id', $friendIds);
    }

    public function friends() {
        return $this->morphMany(Friendship::class, 'sender');
    }

    public function groups() {
        return $this->morphMany(FriendGroup::class, 'friend');
    }

    protected function getOrPaginate($builder, $perPage) {
        if ($perPage == 0) {
            return $builder->get();
        }
        return $builder->paginate($perPage);
    }

}
