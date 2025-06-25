<?php

namespace App\Http\Requests\AdminPanel\PersonRole;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PersonRoleUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'slug' => ['required', 'string', 'min:2', 'max:255', 'regex:/^[a-zA-Z_]+$/', Rule::unique('person_roles')->ignore($this->person_role)],
            'name' => ['required', 'string', 'min:2', 'max:255', Rule::unique('person_roles')->ignore($this->person_role)],
        ];
    }

}
