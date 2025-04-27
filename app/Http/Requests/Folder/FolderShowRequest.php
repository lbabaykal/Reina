<?php

/** @noinspection PhpInconsistentReturnPointsInspection */

namespace App\Http\Requests\Folder;

use Illuminate\Foundation\Http\FormRequest;

class FolderShowRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'folder' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
