<?php

namespace App\Http\Requests;

use App\Models\Country;
use App\Models\Genre;
use App\Models\Studio;
use App\Models\Type;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SearchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation(): void
    {
        if (! $this->filled('sorting')) {
            $this->merge(['sorting' => 'date_added']);
        }

        if (! $this->filled('page')) {
            $this->merge(['page' => 1]);
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
            'title' => ['nullable', 'string', 'max:255'],
            'strict_genre' => ['nullable', 'in:1,0,true,false'],
            'strict_studio' => ['nullable', 'in:1,0,true,false'],

            'types' => ['nullable', 'array'],
            'types.*' => ['nullable', 'string', Rule::in(new Type()->cache()->pluck('slug')->toArray())],

            'genres' => ['nullable', 'array'],
            'genres.*' => ['nullable', 'string', Rule::in(new Genre()->cache()->pluck('slug')->toArray())],

            'genres_exclude' => ['nullable', 'array'],
            'genres_exclude.*' => ['nullable', 'string', Rule::in(new Genre()->cache()->pluck('slug')->toArray())],

            'studios' => ['nullable', 'array'],
            'studios.*' => ['nullable', 'string', Rule::in(new Studio()->cache()->pluck('slug')->toArray())],

            'countries' => ['nullable', 'array'],
            'countries.*' => ['nullable', 'string', Rule::in(new Country()->cache()->pluck('slug')->toArray())],

            'year_from' => ['nullable', 'integer'],
            'year_to' => ['nullable', 'integer'],

            'sorting' => ['nullable', 'string', 'in:date_updated,rating,premiere_asc,premiere_desc'],

            'page' => ['nullable', 'integer'],
        ];
    }
}
