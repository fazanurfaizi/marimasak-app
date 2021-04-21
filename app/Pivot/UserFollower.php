<?php

namespace App\Pivot;

use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Events\User\Followed;
use App\Events\User\Unfollowed;

class UserFollower extends Pivot {

    protected $dispatchesEvents = [
        'created' => Followed::class,
        'deleted' => Unfollowed::class
    ];

}
