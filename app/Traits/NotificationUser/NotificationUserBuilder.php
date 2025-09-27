<?php

namespace App\Traits\NotificationUser;

use App\Models\DefaultNotification;
use App\Models\User;

trait NotificationUserBuilder
{
    public function setUser(User $user): self
    {
        $this->user_id = $user->id;
        return $this;
    }

    public function setNotification(DefaultNotification $defaultNotification): self
    {
        $this->notification_id = $defaultNotification->id;
        return $this;
    }

    public function setSMS(int $send_sms): self
    {
        $this->send_sms = $send_sms;
        return $this;
    }

    public function setEmail(int $send_email): self
    {
        $this->send_email = $send_email;
        return $this;
    }

}
