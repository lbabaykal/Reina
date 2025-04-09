<?php

/** @noinspection PhpInconsistentReturnPointsInspection */

namespace App\Http\Requests\Folder;

use Illuminate\Foundation\Http\FormRequest;

class FolderUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:2', 'max:32'],
            'is_private' => ['required', 'boolean'],
        ];
    }
}
