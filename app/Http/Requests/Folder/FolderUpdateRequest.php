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


    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:32'],
            'is_private' => ['required', 'boolean'],
        ];
    }
}
