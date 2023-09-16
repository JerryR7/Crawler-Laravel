<?php

namespace App\Models\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class searchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "query" => [
                "required"
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'url.required' => 'Please enter text.',
        ];
    }
}
