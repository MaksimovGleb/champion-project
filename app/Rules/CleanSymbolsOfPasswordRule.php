<?php

namespace App\Rules;

use HtmlHelper;
use Illuminate\Contracts\Validation\Rule;

class CleanSymbolsOfPasswordRule implements Rule
{
    protected $password;

    public function __construct($value)
    {
        $this->password = $value;
    }

    public function passes($attribute, $value)
    {
        return HtmlHelper::stripReplace($this->password) === $value;
    }

    public function message()
    {
        return 'Не допустимые символы';
    }
}
