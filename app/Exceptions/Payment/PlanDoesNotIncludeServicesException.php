<?php

namespace App\Exceptions\Payment;

use Exception;

class PlanDoesNotIncludeServicesException extends Exception
{
    protected $message = 'Ваша подписка не включает эту услугу!';

    public function report()
    {
        \Log::debug($this->message);
    }
}
