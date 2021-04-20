<?php

namespace App\Models\Chat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User\User;

class Chatroom extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function owner() {
        return $this->belongsTo(User::class)
            ->withTimestamps();
    }

    public function messages() {
        return $this->hasMany(Message::class);
    }
}
