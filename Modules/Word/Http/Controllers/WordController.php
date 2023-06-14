<?php

namespace Modules\Word\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Modules\Word\Entities\Word;
use Modules\Word\Http\Requests\WordCreateRequest;
use Modules\Word\Http\Requests\WordUpdateRequest;
use Modules\Word\Services\WordService;

class WordController extends Controller
{
    public function show(Word $word)
    {
        return apiResponse(True, $word->toArray(), 'Udalo sie wyswietlic slowo', 200);
    }

    public function store(WordCreateRequest $request)
    {
        $stored = (new WordService())->create($request->all());

        if(!$stored) {return apiResponse(False, [], 'Nie udalo sie stworzyc slowa', 400);}
        else {return apiResponse(True, $stored, 'Udalo sie stworzyc slowo', 200);}
    }

    public function update(WordUpdateRequest $request, Word $word)
    {
        $success = (new WordService())->update($request->all(), $word);

        if(!$success) {return apiResponse(False, [], 'Nie udalo sie stworzyc slowa', 400);}
        else {return apiResponse(True, [], 'Udalo sie stworzyc slowo', 200);}
    }

    public function delete(Word $word)
    {
        $success = (new WordService())->delete($word);

        if(!$success) {return apiResponse(False, [], 'Nie udalo sie usunac slowa', 400);}
        else {return apiResponse(True, [], 'Udalo sie usunac slowo', 200);}
    }

    public function showWordOfTheDay()
    {
        $word = Word::where('id','=',Cache::get('word_of_the_day_id'))->get();

        return apiResponse(True,$word->toArray(),'Zwrocono slowo dnia',200);
    }
}
