<?php

namespace App\Http\Requests\AdminPanel;

use App\Enums\StatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EpisodeUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'number' => ['required', 'integer'],
            'name_org' => ['required', 'string', 'min:1', 'max:255'],
            'name_ru' => ['required', 'string', 'min:1', 'max:255'],
            'name_en' => ['required', 'string', 'min:1', 'max:255'],
            'status' => ['required', Rule::in(StatusEnum::cases())],
            'note' => ['nullable', 'string'],
            'release_date' => ['required', 'date'],
        ];
    }

}
