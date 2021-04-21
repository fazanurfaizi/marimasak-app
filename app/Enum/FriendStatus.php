<?php

namespace App\Enum;

use MyCLabs\Enum\Enum;

final class FriendStatus extends Enum {

    private const PENDING = 0;
    private const ACCEPTED = 1;
    private const DENIED = 2;
    private const BLOCKED = 3;

}
