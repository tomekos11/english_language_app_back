<?php

namespace Modules\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => ['required', 'string', 'email:rfc', 'unique:auth__users,email'],
            'password' => ['required', 'string', 'min:8', 'max:255', 'regex:/(?-i)(?=^.{8,}$)((?!.*\s)(?=.*[A-Z])(?=.*[a-z]))(?=(1)(?=.*\d)|.*[^A-Za-z0-9])^.*$/'],
            'name' => ['required', 'string', 'min:2'],
            'surname' => ['required', 'string', 'min:2'],
            'birth_date' => ['required', 'string', 'date_format:Y-m-d', 'before:today'],
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
