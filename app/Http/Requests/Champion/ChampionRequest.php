<?php

namespace App\Http\Requests\Champion;

use HtmlHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ChampionRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::check();
    }

    public function rules()
    {
        return [
            'tabNumber' => 'nullable',
            'name' => 'required|max:255',
            'surname' => 'required|max:255',
            'patronymic' => 'nullable|max:255',
            'weight' => ['required', 'numeric', 'min:0', 'regex:/^\d+(\.\d{1,2})?$/'], // Ограничение знаков после запятой
            'birth_date' => ['required', 'date', 'before:today'],
            'coach' => 'required|max:255',
            'category' => 'required|integer|min:0',
        ];
    }

    public function attributes()
    {
        return [
            'coach' => 'Тренер',
            'weight' => 'Вес',
            'birth_date' => 'Дата рождения',
            'category' => 'Разряд',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge(['name' => HtmlHelper::stripReplace($this['name'])]);
        $this->merge(['coach' => HtmlHelper::stripReplace($this['coach'])]);
        $this->merge(['surname' => HtmlHelper::stripReplace($this['surname'])]);
        $this->merge(['patronymic' => HtmlHelper::stripReplace($this['patronymic'])]);
    }
}
