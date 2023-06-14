<?php

namespace Modules\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => ['required', 'email:rfc', 'exists:auth__users,email'],
            'password' => ['required', 'string', 'min:8', 'max:255'],
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Podany email nie jest poprawny',
            'email.email' => 'Podany email nie jest poprawny',
            'email.exists' => 'Podany email nie jest poprawny',
            'password.required' => 'Wprowadz haslo',
            'password.string' => 'Hasło jest nieprawidłowe',
            'password.min' => 'Hasło jest nieprawidłowe',
            'password.max' => 'Hasło jest nieprawidłowe',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return is_null($this->user());
    }
}
