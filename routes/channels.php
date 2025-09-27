<?php

//use App\Models\Auth;
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

Broadcast::channel('App.Models.Auth.{id}', function ($user, $id) {
    //return (int) $user->id === (int) $id;
    return true;
});

Broadcast::channel('presence.room.online.{userId}', function ($user) {
    if (User::all()->contains($user)) {
        return $user;
    }
});

Broadcast::channel('presence.task.{taskId}', function ($user, $taskId) {
    if (User::all()->contains($user)) {
        return $user;
    }
});
