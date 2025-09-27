<?php

namespace App\Http\Requests\Judge;

use HtmlHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class JudgeRequest extends FormRequest
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
            'position' => 'required|max:255',
            'country' => 'required|max:255',
            'city' => 'required|max:255',
            'category' => 'required|max:255',
        ];
    }

    public function attributes()
    {
        return [
            'position' => 'Должность',
            'country' => 'Страна',
            'city' => 'Город',
            'category' => 'Категория',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge(['name' => HtmlHelper::stripReplace($this['name'])]);
        $this->merge(['surname' => HtmlHelper::stripReplace($this['surname'])]);
        $this->merge(['patronymic' => HtmlHelper::stripReplace($this['patronymic'])]);
        $this->merge(['position' => HtmlHelper::stripReplace($this['position'])]);
        $this->merge(['country' => HtmlHelper::stripReplace($this['country'])]);
        $this->merge(['city' => HtmlHelper::stripReplace($this['city'])]);
        $this->merge(['category' => HtmlHelper::stripReplace($this['category'])]);
    }
}
