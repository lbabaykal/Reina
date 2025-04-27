<?php

namespace App\Http\Requests\Rating;

use Illuminate\Foundation\Http\FormRequest;

class RatingAnimeRequest extends FormRequest
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
    }

    public function rules(): array
    {
        return [
            'slug' => ['required', 'string'],
            'id' => ['required', 'integer', 'exists:animes,id'],
            'assessment' => ['nullable', 'integer', 'between:1,10'],
        ];
    }
}
