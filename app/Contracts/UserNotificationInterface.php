<?php


namespace App\Contracts;

use Illuminate\Notifications\Notification;

interface UserNotificationInterface
{
    public static function getSubject(Notification $notification): string;
    public static function getMessage(Notification $notification): string;
}
