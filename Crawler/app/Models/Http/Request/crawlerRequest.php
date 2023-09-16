<?php

namespace App\Models\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class crawlerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "url" => [
                "required",
                "url"
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'url.required' => 'The URL field is required.',
            'url.url' => 'The URL must be a valid URL.',
        ];
    }
}
