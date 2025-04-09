<?php

namespace App\Http\Requests\Favorite;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\Rule;

class FavoriteDoramasEpisodeRequest extends FormRequest
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

    public function rules(): array
    {
        return [
            'folder_id' => ['nullable', 'integer',
                Rule::exists('dorama_folders', 'id')
                    ->whereIn('user_id', [0, auth()->id()]),
            ],
            'episode_id' => ['required', 'exists:dorama_episodes,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'folder_id.exists' => Lang::get('reina.folder.is_not_yours'),
            'episode_id.exists' => Lang::get('reina.episode.no_exists'),
        ];
    }
}
