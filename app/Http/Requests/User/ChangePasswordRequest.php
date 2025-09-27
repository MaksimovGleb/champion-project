<?php

namespace App\Http\Requests\User;

use App\Rules\CleanSymbolsOfPasswordRule;
use App\Rules\PasswordAndNewPasswordIsEqualRule;
use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    public function authorize()
    {
        return \Auth::check();
    }

    public function rules()
    {
        return [
            'tabNumber' => 'nullable',
            'password' => ['required', 'min:4', 'max:255', new CleanSymbolsOfPasswordRule($this->password)],
            'password_confirmation' => ['required', 'min:4', 'max:255', new PasswordAndNewPasswordIsEqualRule($this->password)],
        ];
    }

    public function attributes()
    {
        return [
            'password_confirmation' => 'Повторите новый пароль',
        ];
    }
}
