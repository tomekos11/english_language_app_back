<?php

namespace Modules\Word\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryCrUpdRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'min:3', 'unique:word__categories,name'],
        ];
    }

    public function messages()
{
    return [
        'name.required' => 'Podanie nazwy jest wymagane',
        'name.unique' => 'Nazwa kategorii musi byc unikalna',
        'name.min' => 'Nazwa kategorii musi skladac sie co najmniej z trzech znakow',
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
