<?php

namespace Modules\System\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\System\Enums\GameTypeEnum;

class DownloadWordsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type' => ['required','in:'.GameTypeEnum::QUARTER_MINUTE->value.','.GameTypeEnum::HALF_MINUTE->value.','.GameTypeEnum::ONE_MINUTE->value],
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
