<?php

namespace App\Http\Requests\Favorite;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\Rule;

class FavoriteDoramasChangeEpisodeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function prepareForValidation(): void
    {
        if ($this->input('folder_id') === 0) {
            $this->offsetUnset('folder_id');
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'folder_id' => ['nullable', 'integer',
                Rule::exists('dorama_folders', 'id')
                    ->whereIn('user_id', [0, auth()->id()]),
            ],
            'episode' => ['required', 'integer'],
        ];
    }

    public function messages(): array
    {
        return [
            'folder_id.exists' => Lang::get('reina.folder.is_not_yours'),
        ];
    }
}
