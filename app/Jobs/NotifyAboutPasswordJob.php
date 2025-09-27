<?php

namespace App\Jobs;

use App\Events\User\EventAccountCreated;
use App\Events\User\EventAccountCreatedBy;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyAboutPasswordJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected ?User $user;

    public function __construct(User $user = null)
    {
        $this->user = $user;
    }

    public function handle()
    {
        $password = User::generatePassword();
        $this->user->updatePassword($password, true);

        if (\Auth::user()) {
            EventAccountCreatedBy::dispatch($this->user, $password);
        } else {
            EventAccountCreated::dispatch($this->user, $password);
        }
    }
}
