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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $types = cache()->remember('types', 14400, function () {
            return Type::query()->pluck('slug')->toArray();
        });

        $genres = cache()->remember('genres', 14400, function () {
            return Genre::query()->pluck('slug')->toArray();
        });

        $studios = cache()->remember('studios', 14400, function () {
            return Studio::query()->pluck('slug')->toArray();
        });

        $countries = cache()->remember('countries', 14400, function () {
            return Country::query()->pluck('slug')->toArray();
        });

        return [
            'title' => ['nullable', 'string', 'max:255'],
            'strict_genre' => ['nullable', 'in:1,0,true,false'],
            'strict_studio' => ['nullable', 'in:1,0,true,false'],

            'types' => ['nullable', 'array'],
            'types.*' => ['nullable', 'string', Rule::in($types)],

            'genres' => ['nullable', 'array'],
            'genres.*' => ['nullable', 'string', Rule::in($genres)],

            'studios' => ['nullable', 'array'],
            'studios.*' => ['nullable', 'string', Rule::in($studios)],

            'countries' => ['nullable', 'array'],
            'countries.*' => ['nullable', 'string', Rule::in($countries)],

            'year_from' => ['nullable', 'integer'],
            'year_to' => ['nullable', 'integer'],

            'sorting' => ['nullable', 'integer'],

            'page' => ['nullable', 'integer'],
        ];
    }

}
