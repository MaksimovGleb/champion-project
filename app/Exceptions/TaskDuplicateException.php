<?php

namespace App\Exceptions;

use Exception;

class TaskDuplicateException extends Exception
{
    public function report()
    {
        \Log::debug('Заблокирован дубликат!');
    }
}
