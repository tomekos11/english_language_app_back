<?php

namespace Modules\Word\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DictCategoryWordsShowRq extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'category' => ['required'/*, Rule::in(['Wszystkie kategorie']), 'exists:word__categories,name'*/]
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
