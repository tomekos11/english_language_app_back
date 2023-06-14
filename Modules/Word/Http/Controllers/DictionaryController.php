<?php

namespace Modules\Word\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Word\Entities\Category;
use Modules\Word\Entities\Word;
use Modules\Word\Http\Requests\DictCategoryWordsShowRq;
use Illuminate\Support\Facades\DB;

class DictionaryController extends Controller
{
    public function dictionaryIndex(Request $request)
    {
        $mail = $request->user()->email;
        $response = [];
//        $words = Word::all('id', 'word_en', 'word_pl', 'difficulty')->load(['users' => function ($query) use ($mail) {
//            $query->select('word__words_users.is_favourite as is_favourite', 'word__words_users.review as review', 'word__words_users.notes as note')
//                ->where('email', $mail);
//        }]);
//        $words = $words->map(function ($word) {
//           $word->users->makeHidden('pivot');
//            return $word;
//        });
        $categories = Category::all();
        $all_words_amount = Word::all()->count();

        foreach($categories as $category)
        {
            $word_amount = $category->words()->count();
            $category->word_amount = $word_amount;
        }

        $response[] = [/*'words' => $words,*/
        'all_words_amount' =>$all_words_amount,
            'categories' => $categories];
        return apiResponse(true, $response,'Pomyslnie zwrocono slownik',200);
    }

    public function dictionaryShow(DictCategoryWordsShowRq $request)
    {
        $response = [];

        $mail = $request->user()->email;
        if($request->category == "Wszystkie kategorie"){
            $words = Word::all('id', 'word_en', 'word_pl', 'difficulty')->load(['users' => function ($query) use ($mail) {
                $query->select('word__words_users.is_favourite as is_favourite', 'word__words_users.review as review', 'word__words_users.notes as note')
                    ->where('email', $mail);
            }]);
            $words = $words->map(function ($word) {
                $word->users->makeHidden('pivot');
                return $word;
            });
            $response[] = [
                'category' => $request->category,
                'words' => $words];
        }else{
            $words = Category::where('name', $request->category)->with(['words.users' => function ($query) use ($mail) {
                $query->select('word__words_users.is_favourite as is_favourite', 'word__words_users.review as review', 'word__words_users.notes as note')
                    ->where('email', $mail);
            }])->get();

            $words->transform(function ($category) {
                $category->words->transform(function ($word) {
                    $word->makeHidden(['photo_url', 'created_at', 'updated_at']);
                    $word->users->transform(function ($user) {
                        return $user->makeHidden(['pivot']);
                    });
                    return $word;
                });
                return $category;
            });
            $response[] = [
                'category' => $request->category,
                'words' => $words->first()->words];
        }

        return apiResponse(true,$response,'pomyslnie zwrocono slowa dla kategorii '.$request->category,200);

    }
}
