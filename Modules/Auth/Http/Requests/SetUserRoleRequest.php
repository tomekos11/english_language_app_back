<?php

namespace Modules\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Auth\Enums\RoleEnum;

class SetUserRoleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'role' => ['in:'.RoleEnum::ADMIN->value.','.RoleEnum::USER->value],
        ];
    }

    public function messages()
    {
        return [
            'role.in' => 'Uzytkownik moze miec range user albo admin',
        ];
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return !is_null($this->user());
    }
}
