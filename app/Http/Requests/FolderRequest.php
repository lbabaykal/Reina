<?php

/** @noinspection PhpInconsistentReturnPointsInspection */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FolderRequest extends FormRequest
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
        if ($this->isMethod('POST')) {
            return [
                'title' => ['required', 'string', 'min:2', 'max:32'],
                'is_private' => ['required', 'boolean'],
            ];
        }

        if ($this->isMethod('PATCH')) {
            return [
                'title' => ['required', 'string', 'min:2', 'max:32'],
                'is_private' => ['required', 'boolean'],
            ];
        }
    }
}
