<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FriendGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'friendship_id', 'group_id', 'friend_id', 'friend_type'
    ];

    public $timestamps = false;
}
