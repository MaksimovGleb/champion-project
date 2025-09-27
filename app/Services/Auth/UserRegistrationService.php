<?php

namespace App\Services\Auth;

use App\Models\User;

class UserRegistrationService
{

    /**
     * 1. Создаёт пользователя. Рандомный пароль выставится в обсёрвере
     * @param  array  $data
     * @return User
     */
    protected function createUser(array $data): User
    {
        $user = new User(array_filter($data));
        $user->save();

        $user->makeAdmins();
        //$user->setDefaultAvatar();

        return $user;
    }

    public function register(array $data): User
    {
        return $this->createUser($data);
    }
}
