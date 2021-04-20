<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::routes(['middleware' => 'auth:api']);

Broadcast::channel('User.{id}', function($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('chatroom', function($user) {
    return $user;
});

Broadcast::channel('marimasak.chatroom.{chatroom}', function($user, \App\Models\Chat\Chatroom $room) {
    return $room->users->contains('id', $user->id);
});
