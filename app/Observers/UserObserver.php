<?php

namespace App\Observers;

use App\Events\User\EventAccountDeleted;
use App\Events\User\EventAccountUpdated;
use App\Jobs\NotifyAboutPasswordJob;
use App\Models\User;

class UserObserver
{
    public function creating(User $user){
        if (!$user->password)
            $user->password = '####';
    }

    public function created(User $user){
        NotifyAboutPasswordJob::dispatch($user);
    }

    public function updated(User $user)
    {
        $changes = $user->getDirty();

        $interestingChanges =
            array_key_exists('email', $changes) ||
            array_key_exists('name', $changes) ||
            array_key_exists('surname', $changes) ||
            array_key_exists('patronymic', $changes) ||
            array_key_exists('phone', $changes);

        if ($interestingChanges)
            EventAccountUpdated::dispatch($user);

    }

    public function deleted(User $user)
    {
        EventAccountDeleted::dispatch($user);
    }
}
