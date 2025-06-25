<?php

namespace App\Http\Requests\AdminPanel\CharacterRole;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CharacterRoleUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'slug' => ['required', 'string', 'min:2', 'max:255', 'regex:/^[a-zA-Z_]+$/', Rule::unique('character_roles')->ignore($this->character_role)],
            'name' => ['required', 'string', 'min:2', 'max:255', Rule::unique('character_roles')->ignore($this->character_role)],
        ];
    }

}
