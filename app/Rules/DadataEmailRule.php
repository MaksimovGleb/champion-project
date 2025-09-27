<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use MoveMoveIo\DaData\Facades\DaDataEmail;

class DadataEmailRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        try {
            $dadata = DaDataEmail::standardization($value)[0];

            if ($dadata['type'] == 'DISPOSABLE' || $dadata['qc'] != 0) {
                return false;
            }
        } catch (\Exception $e) {
            return true;
        }

        return true;
    }

    public function message()
    {
        return 'Email не соответствует требованиям.';
    }
}
