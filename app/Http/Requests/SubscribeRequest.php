<?php

namespace App\Http\Requests;

use App\Models\Site;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SubscribeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => [
                'required',
                'numeric',
                Rule::exists(table: User::class, column: 'id')
            ],
            'site_id' => [
                'required',
                'numeric',
                Rule::exists(table: Site::class, column: 'id')
            ]
        ];
    }
}
