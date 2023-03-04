<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'min:8', 'max:15', Password::min(8)->mixedCase()->numbers()->symbols()],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'email.required' => 'Email is required',
            'email.email' => 'Email is invalid',
            'email.max' => 'Email is too long',
            'password.required' => 'Password is required',
            'password.min' => 'Password is too short',
            'password.max' => 'Password is too long',
            'password.password' => 'Password is invalid',

        ];
    }
}