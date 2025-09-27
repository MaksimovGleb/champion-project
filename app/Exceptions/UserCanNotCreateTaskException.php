<?php

namespace App\Exceptions;

use Exception;

// php artisan make:exception UserCanNotCreateTaskException
class UserCanNotCreateTaskException extends Exception
{
    public function report()
    {
        \Log::debug('Клиент не может создавать задачи. Проверьте баланс ');
    }
}
