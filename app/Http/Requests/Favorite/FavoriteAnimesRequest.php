<?php

namespace App\Http\Requests\Favorite;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\Rule;

class FavoriteAnimesRequest extends FormRequest
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
            'folder_id' => ['required', 'integer',
                Rule::exists('anime_folders', 'id')
                    ->whereIn('user_id', [0, auth()->id()]),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'folder_id.exists' => Lang::get('reina.folder.is_not_yours'),
        ];
    }
}
