<?php

namespace App\Exceptions;

use App\Enums\UserRoles;
use Exception;

class UserNotUristException extends Exception
{
    /**
     * Report or log an exception.
     *
     * @return void
     */
    public function report()
    {
        \Log::debug('Невозможно сделать пользователя ответственным юристом, т.к он не находится в группе: '. UserRoles::UserUristRoleSlug);
    }
}
