<?php

namespace App\Events\User;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Pivot\UserFollower;

class Followed
{
    use Dispatchable, SerializesModels;

    public $followingId;

    public $followerId;

    protected $relation;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(UserFollower $relation)
    {
        $this->relation = $relation;
        $this->followerId = $relation->follower_id;
        $this->followingId = $relation->following_id;
    }
}
