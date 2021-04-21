<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enum\FriendStatus;

class Friendship extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    public function sender() {
        return $this->morphTo('sender');
    }

    public function recipient() {
        return $this->morphTo('recipient');
    }

    public function groups() {
        return $this->hasMany(FriendGroup::class, 'friendship_id');
    }

    public function fillRecipient($recipient) {
        return $this->fill([
            'recipient_id' => $recipient->getKey(),
            'recipient_type' => $recipient->getMorphClass()
        ]);
    }

    public function scopeWhereRecipient($query, $model) {
        return $query->where('recipient_id', $model->getKey())
            ->where('recipient_type', $model->getMorphClass());
    }

    public function scopeWhereSender($query, $model) {
        return $query->where('sender_id', $model->getKey())
            ->where('sender_type', $model->getMorphClass());
    }

    public function scopeWhereGroup($query, $model, $groupSlug) {

        $groupsPivotTable   = config('friendships.tables.fr_groups_pivot');
        $friendsPivotTable  = config('friendships.tables.fr_pivot');
        $groupsAvailable = config('friendships.groups', []);

        if ('' !== $groupSlug && isset($groupsAvailable[$groupSlug])) {

            $groupId = $groupsAvailable[$groupSlug];

            $query->join($groupsPivotTable, function ($join) use ($groupsPivotTable, $friendsPivotTable, $groupId, $model) {
                $join->on($groupsPivotTable . '.friendship_id', '=', $friendsPivotTable . '.id')
                    ->where($groupsPivotTable . '.group_id', '=', $groupId)
                    ->where(function ($query) use ($groupsPivotTable, $friendsPivotTable, $model) {
                        $query->where($groupsPivotTable . '.friend_id', '!=', $model->getKey())
                            ->where($groupsPivotTable . '.friend_type', '=', $model->getMorphClass());
                    })
                    ->orWhere($groupsPivotTable . '.friend_type', '!=', $model->getMorphClass());
            });

        }

        return $query;

    }

    public function scopeBetweenModels($query, $sender, $recipient) {
        $query->where(function ($queryIn) use ($sender, $recipient){
            $queryIn->where(function ($q) use ($sender, $recipient) {
                $q->whereSender($sender)->whereRecipient($recipient);
            })->orWhere(function ($q) use ($sender, $recipient) {
                $q->whereSender($recipient)->whereRecipient($sender);
            });
        });
    }
}
