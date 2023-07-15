<?php

namespace App\Http\Requests;

use App\Models\Site;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'min:3', 'max:255', 'string'],
            'site_id' => [
                'required',
                'numeric',
                Rule::exists(table: Site::class, column: 'id'),
            ],
            'body' => ['required',]
        ];
    }
}
