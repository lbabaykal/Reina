<?php

namespace App\Http\Requests\AdminPanel;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TypeUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'title_ru' => ['required', 'min:2', 'max:255', 'regex:/^[\p{Cyrillic}\s]+$/u', Rule::unique('types')->ignore($this->type)],
            'title_en' => ['required', 'min:2', 'max:255', 'regex:/^[\p{Latin}\s]+$/u', Rule::unique('types')->ignore($this->type)],
        ];
    }
}
