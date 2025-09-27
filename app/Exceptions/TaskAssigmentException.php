<?php

namespace App\Exceptions;

use Exception;

class TaskAssigmentException extends Exception
{
    public function report()
    {
        \Log::debug('Попытка назначить заявку саму себе ');
    }
}
