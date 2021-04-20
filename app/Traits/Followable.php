<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait Followable {

    public function needsToApproveFollowRequests() {
        return false;
    }

    public function follow($user) {
        $isPending = $user->needsToApproveFollowRequests() ?: false;

        $this->followings()->attach($user, [
            'accpeted_at' => $isPending ? null : now()
        ]);

        return [
            'pending' => $isPending
        ];
    }

    public function unfollow($user) {
        $this->followings()->detach($user);
    }

    public function toggleFollow($user) {
        $this->isFollowing($user) ? $this->unfollow($user) : $this->follow($user);
    }

    public function rejectFollowRequestFrom($user) {
        $this->followers()->detach($user);
    }

    public function acceptFollowRequestFrom($user) {
        $this->followers()->updateExistingPivot($user, [
            'accepted_at' => now()
        ]);
    }

    public function hasRequestToFollow($user): bool {
        if($user instanceof Model) {
            $user = $user->getKey();
        }

        if($this->relationLoaded('followings')) {
            return $this->followings
                ->where('pivot.accpeted_at', '===', null)
                ->contains($user);
        }

        return $this->followings()
            ->wherePivot('accepted_at', null)
            ->where($this->getQualifiedKeyName(), $user)
            ->exists();
    }

    public function isFollowing($user) {
        if($user instanceof Model) {
            $user = $user->getKey();
        }

        if($this->relationLoaded('followings')) {
            return $this->followings()
                ->wherePivot('accepted_at', '!=', null)
                ->where($this->getQualifiedKeyName(), $user)
                ->contains($user);
        }

        return $this->followings()
            ->wherePivot('accepted_at', '!=', null)
            ->where($this->getQualifiedKeyName(), $user)
            ->exists();
    }

    public function isFollowedBy($user) {
        if ($user instanceof Model) {
            $user = $user->getKey();
        }

        if ($this->relationLoaded('followers')) {
            return $this->followers
                ->wherePivot('accepted_at', '!=', null)
                ->contains($user);
        }

        return $this->followers()
            ->wherePivot('accepted_at', '!=', null)
            ->where($this->getQualifiedKeyName(), $user)
            ->exists();
    }

    public function areFollowingEachOther($user) {
        return $this->isFollowing($user) && $this->isFollowedBy($user);
    }

    public function followers() {
        return $this->belongsToMany(
            __CLASS__,
            'user_follower',
            'following_id',
            'follower_id'
        )->withPivot('accepted_at')->withTimestamps()->using(UserFollower::class);
    }

    public function followings() {
        return $this->belongsToMany(
            __CLASS__,
            'user_follower',
            'follower_id',
            'following_id'
        )->withPivot('accepted_at')->withTimestamps()->using(UserFollower::class);
    }

}
