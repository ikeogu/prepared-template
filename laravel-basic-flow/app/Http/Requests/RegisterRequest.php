<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            //
            'name' => ['string','required'],
            'email' => ['required','string'],
            'password' => ['required','confirmed',
            Password::min(8)->letters()
                ->mixedCase()
                ->numbers()
                ->symbols()
                ->uncompromised()

        ],
        'is_subscribed' => ['required', 'boolean']
        ];
    }

   /*  public function messages() : array
    {
        return [

        ]
    } */
}