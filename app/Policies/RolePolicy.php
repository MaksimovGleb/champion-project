<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    /** Право на просмотр таблицы ролей */
    public function viewAny(User $user): bool
    {
        // Я Админ
        if ($user->isAdmin(true)) {
            return true;
        }

        return false;
    }

    /** Право на просмотр роли  */
    public function view(User $user, Role $role): bool
    {
        // Я Админ
        if ($user->isAdmin(true)) {
            return true;
        }

        return false;
    }

    /** Право на создание роли */
    public function create(User $user): bool
    {
        // Я Админ
        if ($user->isAdmin(true)) {
            return true;
        }

        return false;
    }

    /** Право на изменение роли */
    public function update(User $user, Role $role): bool
    {
        // Я Админ
        if ($user->isAdmin(true)) {
            return true;
        }

        return false;
    }

    /** Право на удаление роли */
    public function delete(User $user, Role $role): bool
    {
        // Я Админ
        if ($user->isAdmin(true)) {
            return true;
        }

        return false;
    }
}
