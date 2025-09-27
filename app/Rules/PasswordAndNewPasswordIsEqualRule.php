<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PasswordAndNewPasswordIsEqualRule implements Rule
{
    protected $password;

    public function __construct($value)
    {
        $this->password = $value;
    }

    public function passes($attribute, $value)
    {
        return $this->password === $value;
    }

    public function message()
    {
        return 'Пароли должны совпадать';
    }
}
