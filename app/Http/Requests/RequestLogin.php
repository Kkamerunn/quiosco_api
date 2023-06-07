<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestLogin extends FormRequest
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
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'The email is required',
            'email.email' => 'The email is invalid',
            'email.exists' => 'This account does not exist',
            'password' => 'The password is required'
        ];
    }
}
