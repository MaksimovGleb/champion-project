<?php

namespace App\Policies;

use App\Models\DefaultNotification;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NotificationSettingsPolicy
{
    use HandlesAuthorization;


    /** Право на просмотр настроек получения уведомлений */
    public function notificationSettings(User $user, User $who): bool
    {
        $hasEditableNotifications = DefaultNotification::where(function ($query) {
            $query->where('edit_sms', true)
                ->orWhere('edit_email', true);
        })->exists();
        if ($hasEditableNotifications) {
            if ($user->id == $who->id)
                return true;

            // Я Админ
            return $user->isAdmin(true);
        }

        return false;
    }

    /** Право на изменение настроек получения уведомлений */
    public function notificationSettingsUpdate(User $user, User $who): bool
    {
        if ($user->id == $who->id)
            return true;

        // Я Админ
        return $user->isAdmin(true);
    }

    /** Право на просмотр настроек по умолчанию для уведомлений */
    public function defaultSettings(User $user): bool
    {
        // Я Админ
        return $user->isAdmin(true);
    }

    /** Право на изменение настроек по умолчанию для уведомлений */
    public function updateDefaultSettings(User $user, DefaultNotification $defaultNotification): bool
    {
        // Я Админ
        return $user->isAdmin(true);
    }

}
