<?php

namespace App\Policies;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PermissionPolicy
{
    use HandlesAuthorization;

    /** Право на просмотр таблицы Прав */
    public function viewAny(User $user): bool
    {
        // Я Админ
        if ($user->isAdmin(true)) {
            return true;
        }

        return false;
    }

    /** Право на просмотр Права  */
    public function view(User $user, Permission $permission): bool
    {
        // Я Админ
        if ($user->isAdmin(true)) {
            return true;
        }

        return false;
    }

    /** Право на создание Права */
    public function create(User $user): bool
    {
        // Я Админ
        if ($user->isAdmin(true)) {
            return true;
        }

        return false;
    }

    /** Право на изменение Права */
    public function update(User $user, Permission $permission): bool
    {
        // Я Админ
        if ($user->isAdmin(true)) {
            return true;
        }

        return false;
    }

    /** Право на удаление Права */
    public function delete(User $user, Permission $permission): bool
    {
        // Я Админ
        if ($user->isAdmin(true)) {
            return true;
        }

        return false;
    }
}
