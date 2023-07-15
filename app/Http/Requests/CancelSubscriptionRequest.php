<?php

namespace App\Http\Requests;

use Closure;
use App\Models\Site;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Http\FormRequest;

class CancelSubscriptionRequest extends FormRequest
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
                Rule::exists(table: Site::class, column: 'id'),
                function (string $attribute, mixed $value, Closure $fail) {
                    $doesntExist = DB::table('subscriptions')
                        ->where('user_id', '=', $this->input('user_id'))
                        ->where('site_id', '=', $value)
                        ->doesntExist();

                    if ($doesntExist) {
                        $fail("The user is not subscribed to this site");
                    }
                },
            ]
        ];
    }
}
