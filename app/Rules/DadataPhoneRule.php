<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use MoveMoveIo\DaData\Facades\DaDataPhone;

class DadataPhoneRule implements Rule
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
            $dadata = DaDataPhone::standardization($value)[0];

            if ($dadata['type'] == 'Неизвестный' || ! in_array($dadata['qc'], [0, 7])) {
                return false;
            }
        } catch (\Exception $e) {
            // dd($e->getMessage());
            return true;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Телефон не соответствует требованиям.';
    }
}
