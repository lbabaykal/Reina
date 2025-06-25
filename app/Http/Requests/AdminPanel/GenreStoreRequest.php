<?php

namespace App\Http\Requests\AdminPanel;

use Illuminate\Foundation\Http\FormRequest;

class GenreStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'title_ru' => ['required', 'min:2', 'max:255', 'unique:genres,title_ru', 'regex:/^[\p{Cyrillic}\s]+$/u'],
            'title_en' => ['required', 'min:2', 'max:255', 'unique:genres,title_en', 'regex:/^[\p{Latin}\s]+$/u'],
        ];
    }

}
