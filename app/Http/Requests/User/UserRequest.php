<?php

namespace App\Http\Requests\User;

use App\Models\Referral;
use App\Models\User;
use App\Rules\DadataPhoneRule;
use HtmlHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserRequest extends FormRequest
{
    // Проверяем доступ
    public function authorize()
    {
        return Auth::check();
    }

    public function rules()
    {
        $userId = Auth::user()->id;
        return [
            'tabNumber' => 'nullable',
            'name' => 'required|max:255',
            'email' => ['sometimes', 'nullable', 'email:rfc,dns', 'unique:users,email,'.$this->id, 'max:255'],
            'phone' => ['required', 'unique:users,phone,'.$this->id, 'numeric', 'min:10', new DadataPhoneRule()],   // unique:users,phone,'.$this->id,
            'surname' => 'required|max:255',
            'patronymic' => 'nullable|max:255',
            'avatar' => 'file|max:20480|image|dimensions:min_width=160,min_height=160',
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

        $this->merge(['name' => HtmlHelper::stripReplace($this['name'])]);
        $this->merge(['email' => HtmlHelper::stripReplace($this['email'])]);
        $this->merge(['surname' => HtmlHelper::stripReplace($this['surname'])]);
        $this->merge(['patronymic' => HtmlHelper::stripReplace($this['patronymic'])]);
    }
}
