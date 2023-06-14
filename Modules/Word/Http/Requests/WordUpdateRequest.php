<?php

namespace Modules\Word\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Word\Enums\DifficultyEnum;

class WordUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'word_en' => ['string', 'max:255', 'min:1'],
            'word_pl' => ['string', 'max:255', 'min:1'],
            'difficulty' => ['string', 'in:'.
                DifficultyEnum::EASY->value.','.
                DifficultyEnum::MEDIUM->value.','.
                DifficultyEnum::HARD->value],
        ];
    }

    public function messages()
{
    return [

        'word_en.min' => 'Slowko angielskie musi mieć co najmniej 1 znak.',
        'word_en.min' => 'Slowko angielskie musi mieć co maksymalnie 255 znaki.',

        'word_pl.min' => 'Slowko polskie musi mieć co najmniej 1 znak.',
        'word_pl.min' => 'Slowko polskie musi mieć co maksymalnie 255 znaki.',

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
