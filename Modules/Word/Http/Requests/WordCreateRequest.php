<?php

namespace Modules\Word\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Word\Enums\DifficultyEnum;

class WordCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'category_id' => ['required'],
            'word_en' => ['required', 'string', 'max:255', 'min:1'],
            'word_pl' => ['required' ,'string', 'max:255', 'min:1'],
            'difficulty' => ['required', 'string', 'in:'.
                DifficultyEnum::EASY->value.','.
                DifficultyEnum::MEDIUM->value.','.
                DifficultyEnum::HARD->value],
        ];
    }

    public function messages()
{
    return [
        'category_id.required' => 'Ustawienie kategorii jest wymagane.',

        'word_en.required' => 'Slowko angielskie jest wymagane.',
        'word_en.min' => 'Slowko angielskie musi mieć co najmniej 1 znak.',
        'word_en.min' => 'Slowko angielskie musi mieć co maksymalnie 255 znaki.',

        'word_pl.required' => 'Slowko polskie jest wymagane.',
        'word_pl.min' => 'Slowko polskie musi mieć co najmniej 1 znak.',
        'word_pl.min' => 'Slowko polskie musi mieć co maksymalnie 255 znaki.',

        'difficulty.required' => 'Poziom trudnosci musi byc uzupelniony.',
        'difficulty.regex' => 'Poziom trudnosci musi miec postac latwy / sredni / trudny',

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
