<?php

namespace App\Http\Requests\AdminPanel\PersonRole;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PersonRoleStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'slug' => ['required', 'string', 'min:2', 'max:255', 'regex:/^[a-zA-Z_]+$/', 'unique:person_roles,slug'],
            'name' => ['required', 'string', 'min:2', 'max:255', 'unique:person_roles,name'],
        ];
    }

}
