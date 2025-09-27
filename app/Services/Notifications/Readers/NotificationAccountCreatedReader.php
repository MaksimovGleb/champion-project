<?php

namespace App\Services\Notifications\Readers;

use App\Contracts\Notifications\Reader\NotificationReader;
use App\Models\User;
use Illuminate\Notifications\DatabaseNotification;
use Str;

class NotificationAccountCreatedReader extends NotificationReader
{
    private ?User $user;

    public function __construct(DatabaseNotification $notification)
    {
        parent::__construct($notification);
        $this->user = User::Find($this->notification->notifiable_id);
    }

    public function getText(bool $short = false): string
    {
        $result = '';
        $config = config('myurist.str_max_length');

        if ($this->user) {
            $result = sprintf(
                "%s зарегистрировался",
                $this->user?->FullName,
            );
        }

        return $short ? Str::of($result)->limit($config) : $result;
    }

    public function getData(): array
    {
        $data = $this->notification->data;
        $data['user_id'] = '';
        if ($this->user) {
            $data['user_id'] = $this->user->id;
        }
        return [
            'url' => route('user.show',$data['user_id']),
            'user_id' => $data['user_id'],
            'data' => $data,
        ];
    }
}
