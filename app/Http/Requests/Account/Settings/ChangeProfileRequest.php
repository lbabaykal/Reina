<?php

namespace App\Http\Requests\Account\Settings;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class ChangeProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'avatar' => ['nullable', 'file', 'mimes:png,jpg,webp', File::image()->min('1kb')->max('2mb')],
            'name' => ['required', 'string', 'min:1', 'max:32', Rule::unique(User::class)->ignore($this->user()->id)],
        ];
    }
}
