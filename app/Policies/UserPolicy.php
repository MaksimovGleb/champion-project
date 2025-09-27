<?php

namespace App\Policies;

use App\Models\Permission;
use App\Models\Region;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Redirect;

class UserPolicy
{
    use HandlesAuthorization;

    /** Право на экспорт таблиц */
    public function export(User $user): bool
    {
        // Я Админ
        if ($user->isAdmin(true)) {
            return true;
        }
        return false;
    }

    /** Право на просмотр таблицы профилей */
    public function viewAny(User $user): bool
    {
        // Я Админ
        if ($user->isAdmin(true)) {
            return true;
        }

        return false;
    }

    /** Право на регистрацию пользователя */
    public function create(User $user): bool
    {
        // Я Админ
        if ($user->isAdmin(true)) {
            return true;
        }

        return false;
    }

    /** Право на просмотр профиля */
    public function view(User $user, User $who, $checkActiveRole = true): bool
    {
        // это мой профиль
        if ($who->id === $user->id) {

            return true;
        }

        // Я Админ
        if ($user->isAdmin($checkActiveRole)) {
            return true;
        }

        return false;
    }

    /** Право на просмотр юриста */
    public function viewUrist(User $user): bool
    {
        return true;
    }

    /** Право на изменение роли и прав профиля */
    public function updateRolesAndPermissions(User $user): bool
    {
        // Я Админ
        if ($user->isAdmin(true)) {
            return true;
        }
        return false;
    }

    /** Право на редактирование профиля */
    public function update(User $user, User $who): bool
    {
        // это мой профиль
        if ($who->id === $user->id) {
            return true;
        }

        // Я Админ
        if ($user->isAdmin(true)) {
            return true;
        }

        return false;
    }

    /** Право задать при создании зарегистрировавшего или пригласившего */
    public function createCreator(User $user): bool
    {
        // Я Админ
        if ($user->isAdmin(true)) {
            return true;
        }

        return false;
    }

    /** Право на редактирование зарегистрировавшего или пригласившего */
    public function updateCreator(User $user, User $who): bool
    {
        // Я Админ
        if ($user->isAdmin(true)) {
            return true;
        }

        return false;
    }

    /** Право на изменение пароля */
    public function changePassword(User $user, User $who): bool
    {
        // это мой профиль
        if ($who->id === $user->id) {
            return true;
        }

        // Я Админ
        if ($user->isAdmin(true)) {
            return true;
        }

        return false;
    }

    /** Право на удаление пользователя */
    public function delete(User $user, User $who): bool
    {
        if ($user->isAdmin() && $user->id != $who->id) {
            return true;
        }

        return false;
    }

//----------------------------------------------------------------------------//
    /** Задать активную роль */
    public function admin(User $user): bool
    {
        if ($user->isAdmin()) {
            $activeRole = $user->getActiveRole();

            return $activeRole->id === Role::Admin()->id;
        }

        return false;
    }

}
