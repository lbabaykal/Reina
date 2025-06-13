<?php

namespace App\Http\Requests\AdminPanel;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class CharacterUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'photo' => ['nullable', 'file', 'mimes:png,jpg,webp,avif', File::image()->min('1kb')->max('4mb')],
            'full_name_org' => ['required', 'string', 'min:1', 'max:255'],
            'full_name_ru' => ['required', 'string', 'min:1', 'max:255'],
            'full_name_en' => ['required', 'string', 'min:1', 'max:255'],
            'description' => ['nullable', 'string'],
        ];
    }

}
