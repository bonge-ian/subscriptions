<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if ($this->method() === 'PUT') {
            return [
                'title' => ['required', 'min:3', 'max:255', 'string'],
                'body' => ['required']
            ];
        }

        return [
            'title' => ['sometimes', 'required', 'min:3', 'max:255', 'string'],
            'body' => ['sometimes', 'required']
        ];
    }
}
