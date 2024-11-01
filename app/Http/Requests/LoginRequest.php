<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

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
     * @return array
     */
    public function rules()
    {
        return [
            // 'email'=>'required|string|email|exists:users,email',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::exists('users', 'email')
            ],
            'password' => 'required|min:8',
            'remember_me' => 'boolean'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Le champ email est requis.',
            'email.exists' => 'L\'adresse email est introuvable.',
            'password.min' => 'Le mot de passe doit contenu au moins 8 caractères.',
            'password.required' => 'Le champ mot de passe est requis.'
        ];
    }
}
