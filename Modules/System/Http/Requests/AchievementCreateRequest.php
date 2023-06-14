<?php

namespace Modules\System\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AchievementCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['string', 'required'],
            'event_type' => ['string', 'required'],
            'value' => ['required','int', 'min:1', 'max:200'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nazwa jest wymagana',
            'event_type.required' => 'Event type jest wymagany',
            'value.required' => 'Wartosc jest wymagana',
            'value.int' => 'Wartosc musi byc liczba calkowita',
            'value.min' => 'Wartosc minimalna to 1',
            'value.max' => 'Wartosc maksymalna to 200',
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
        ;
    }
}
