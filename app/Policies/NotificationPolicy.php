<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Notifications\DatabaseNotification;

class NotificationPolicy
{
    use HandlesAuthorization;

    /** Право на просмотр уведомлений */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /** Право на просмотр всех (чужих) уведомлений */
    public function viewAllAny(User $user): bool
    {
        // Я Админ
        return $user->isAdmin(true);
    }

    /** Право на прочтение уведомления */
    public function update(User $user, DatabaseNotification $databaseNotification): bool
    {
        // уведомление отправлено мне
        if ($databaseNotification->notifiable_id == $user->id) {
            return true;
        }
        // Я Админ
        return $user->isAdmin(true);
    }

    /** Право на прочтение всех уведомления */
    public function updateAll(User $user, DatabaseNotification $databaseNotification): bool
    {
        // уведомление отправлено мне
        if ($databaseNotification->notifiable_id == $user->id) {
            return true;
        }

        return false;
    }

    /** Право на удаление уведомления */
    public function delete(User $user, DatabaseNotification $databaseNotification): bool
    {
        // уведомление отправлено мне
        if ($databaseNotification->notifiable_id == $user->id) {
            return true;
        }

        return false;
    }

    /** Право на удаление всех уведомления */
    public function deleteAll(User $user): bool
    {
        // Я Админ
        return $user->isAdmin(true);
    }
}
