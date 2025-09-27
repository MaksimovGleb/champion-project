<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ChangeUserMarkedRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::check();
    }

    public function rules()
    {
        return [
            'user_id' => 'exists:App\Models\User,id',
            'checked'=> 'required|boolean',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge(['checked' => filter_var($this->checked ?? false, FILTER_VALIDATE_BOOLEAN)]);
    }
}
