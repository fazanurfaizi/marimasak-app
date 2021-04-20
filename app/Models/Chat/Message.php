<?php

namespace App\Models\Chat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User\User;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'body',
        'filename',
        'filetype',
        'user_id'
    ];

    protected $touches = ['chatroom'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function chatroom() {
        return $this->belongsTo(ChatRoom::class);
    }
}
