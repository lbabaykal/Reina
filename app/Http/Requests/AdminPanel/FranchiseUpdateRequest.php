<?php

namespace App\Http\Requests\AdminPanel;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FranchiseUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'title_ru' => ['required', 'min:2', 'max:255', Rule::unique('franchises')->ignore($this->franchise)],
            'title_en' => ['required', 'min:2', 'max:255', Rule::unique('franchises')->ignore($this->franchise)],
        ];
    }
}
