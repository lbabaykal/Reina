<?php

namespace App\Http\Requests\Favorite;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\Rule;

class FavoriteDoramasRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'id' => getIdFromSlug($this->slug),
        ]);

        if ($this->input('folder_id') === null) {
            $this->offsetUnset('folder_id');
        }

        if ($this->input('episode_id') === null) {
            $this->offsetUnset('episode_id');
        }
    }

    public function rules(): array
    {
        return [
            'slug' => ['required', 'string'],
            'id' => ['required', 'integer', 'exists:doramas,id'],
            'folder_id' => ['nullable', 'integer',
                Rule::exists('dorama_folders', 'id')
                    ->whereIn('user_id', [0, auth()->id()]),
            ],
            'episode_id' => ['nullable', 'integer', 'exists:dorama_episodes,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'folder_id.exists' => Lang::get('reina.folder.is_not_yours'),
        ];
    }
}
