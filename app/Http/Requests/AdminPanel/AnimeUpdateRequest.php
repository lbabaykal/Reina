<?php

namespace App\Http\Requests\AdminPanel;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class AnimeUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function prepareForValidation(): void
    {
        $id = getIdFromSlug($this->route('slug'));

        $this->merge([
            'id' => $id,
        ]);
    }

    public function rules(): array
    {
        return [
            'id' => ['required', 'integer', 'exists:animes,id'],
            'poster' => ['nullable', 'file', 'mimes:png,jpg', File::image()->min('1kb')->max('4mb')],
            'cover' => ['nullable', 'file', 'mimes:png,jpg', File::image()->min('1kb')->max('4mb')],

            'title_org' => ['required', 'string', 'min:1', 'max:255', Rule::unique('animes')->ignore($this->id)],
            'title_ru' => ['required', 'string', 'min:1', 'max:255',  Rule::unique('animes')->ignore($this->id)],
            'title_en' => ['required', 'string', 'min:1', 'max:255', Rule::unique('animes')->ignore($this->id)],

            'type' => ['required', 'integer', 'exists:types,id'],

            'genres' => ['nullable', 'array'],
            'genres.*' => ['nullable', 'integer', 'exists:genres,id'],

            'studios' => ['nullable', 'array'],
            'studios.*' => ['nullable', 'integer', 'exists:studios,id'],

            'country' => ['required', 'integer', 'exists:countries,id'],

            'age_rating' => ['required', Rule::in(\App\Enums\AgeRatingEnum::cases())],

            'episodes_total' => ['required', 'integer'],
            'duration' => ['required', 'integer'],
            'release' => ['required', 'date', 'after:1980-01-01|', 'before:2100-01-01'],
            'description' => ['nullable', 'string'],
            'status' => ['required', Rule::in(\App\Enums\StatusEnum::cases())],
            'is_comment' => ['nullable', 'string'],
            'is_rating' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'type.integer' => 'Необходимо заполнить Тип',
            'country.integer' => 'Необходимо заполнить Страну',
        ];
    }

}
