<?php

namespace App\Http\Requests\AdminPanel;

use Illuminate\Foundation\Http\FormRequest;

class FranchiseStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'title_ru' => ['required', 'min:2', 'max:255', 'unique:franchises,title_ru'],
            'title_en' => ['required', 'min:2', 'max:255', 'unique:franchises,title_en'],
        ];
    }
}
