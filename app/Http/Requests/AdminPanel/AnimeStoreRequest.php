<?php

namespace App\Http\Requests\AdminPanel;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class AnimeStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'poster' => ['nullable', 'file', 'mimes:png,jpg', File::image()->min('1kb')->max('4mb')],
            'cover' => ['nullable', 'file', 'mimes:png,jpg', File::image()->min('1kb')->max('4mb')],

            'title_org' => ['required', 'string', 'min:1', 'max:255', 'unique:animes,title_org'],
            'title_ru' => ['required', 'string', 'min:1', 'max:255',  'unique:animes,title_ru'],
            'title_en' => ['required', 'string', 'min:1', 'max:255', 'unique:animes,title_en'],

            'type' => ['required', 'integer', 'exists:types,id'],

            'genres' => ['nullable', 'array'],
            'genres.*' => ['nullable', 'integer', 'exists:genres,id'],

            'studios' => ['nullable', 'array'],
            'studios.*' => ['nullable', 'integer', 'exists:studios,id'],

            'countries' => ['nullable', 'array'],
            'countries.*' => ['nullable', 'integer', 'exists:countries,id'],

            'age_rating' => ['required', Rule::in(\App\Enums\AgeRatingEnum::cases())],

            'episodes_total' => ['required', 'integer'],
            'duration' => ['required', 'integer'],
            'release' => ['required', 'date', 'after:1980-01-01|', 'before:2100-01-01'],
            'description' => ['nullable', 'string'],
            'status' => ['required', Rule::in(\App\Enums\StatusEnum::cases())],
            'is_comment' => ['nullable', 'in:on,1'],
            'is_rating' => ['nullable', 'in:on,1'],
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
