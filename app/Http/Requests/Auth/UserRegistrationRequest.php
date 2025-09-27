<?php

namespace App\Http\Requests\Auth;

use App\Rules\DadataEmailRule;
use App\Rules\DadataPhoneRule;
use Illuminate\Foundation\Http\FormRequest;

class UserRegistrationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'email.unique' => 'Учётная запись с таким email уже существует!',
        ];
    }

    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'email' => ['required_if:phone,null', 'unique:users', 'email', 'max:255', new DadataEmailRule()],
            'phone' => ['required_if:email,null', 'unique:users', 'numeric', 'min:10', new DadataPhoneRule()],
        ];
    }

    private function processPhone()
    {
        $phone = preg_replace('/[^0-9]/', '', $this->phone);
        if (empty($phone)) {
            return '';
        }
        if ($phone[0] == '8') {
            $phone[0] = '7';
        }

        return $phone;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'phone' => $this->processPhone(),
        ]);
    }
}
