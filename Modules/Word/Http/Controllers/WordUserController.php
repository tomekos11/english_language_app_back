<?php

namespace Modules\Word\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Word\Entities\Category;
use Modules\Word\Entities\Word;
use Modules\Word\Http\Requests\AddNoteRequest;
use Modules\Word\Http\Requests\CategoryReviewsRequest;
use Modules\Word\Http\Requests\changeReviewStatusRequest;
use Modules\Word\Http\Requests\UserLoggedInRequest;
use Modules\Word\Services\UserWordsService;

class WordUserController extends Controller
{
    public function indexFavourite(UserLoggedInRequest $request)
    {
        $favourites = $request->user()
            ->words()
            ->where('is_favourite','=',1)
            ->get()
            ->toArray();

            foreach($favourites as &$fav)
            {
                unset($fav['pivot']['user_id']);
                unset($fav['pivot']['word_id']);
            }

        return apiResponse(True, $favourites, 'Zwrocono ulubione slowa uzytkownika', 200);
    }

    public function indexReview(Request $request)
    {
        $reviews = $request->user()
            ->words()
            ->where('review','=',1)
            ->where('review_done','=',0)
            ->get()
            ->toArray();

        foreach($reviews as &$review)
        {
            unset($review['pivot']['user_id']);
            unset($review['pivot']['word_id']);
        }


        return apiResponse(True, $reviews, 'Zwrocono powtorki uzytkownika', 200);
    }

    public function indexCategoryReviews(CategoryReviewsRequest $request)
    {
        $category = Category::where('name','=', $request->category)->first()->id;

        $reviews = $request->user()
            ->words()
            ->where('review','=',1)
            ->where('review_done','=',0)
            ->where('category_id','=',$category)
            ->get()
            ->toArray();

        foreach($reviews as &$review)
        {
            unset($review['pivot']['user_id']);
            unset($review['pivot']['word_id']);
        }

        if($reviews)return apiResponse(True, $reviews, 'Zwrocono powtorki uzytkownika', 200);
        else return apiResponse(True, [], 'Nie udalo sie znalezc powtorek dla tej kategorii', 404);

    }

    public function addToFavourite(UserLoggedInRequest $request, Word $word)
    {
        $array = [];
        $success = (new UserWordsService)->addToFavourite($word, $request->user());
        $array['achievement'] = $success[0] ?? $success = [];
        $array['money'] = $request->user()->money;
        if(!$success) {
            return apiResponse(False, [], 'Nie udalo sie dodac do ulubionych', 400);
        }
        return apiResponse(True, ['update'=> $array], 'Dodano do ulubionych', 200);
    }

    public function revokeFromFavourite(UserLoggedInRequest $request, Word $word)
    {
        $success = (new UserWordsService)->revokeFromFavourite($word, $request->user());

        if(!$success) {
            return apiResponse(False, [], 'Nie udalo sie usunac z ulubionych', 400);
        }
        return apiResponse(True, [], 'Usunieto z ulubionych', 200);
    }

    public function addNote(AddNoteRequest $request, Word $word)
    {
        $notes = $request->notes ?? '';
        if(!strlen($notes)) {
            return apiResponse(False, [], 'Nie udalo sie dodac notatek', 400);
        }
        $success = (new UserWordsService)->addNote($notes, $word, $request->user());

        if(!$success) {
            return apiResponse(False, [], 'Nie udalo sie dodac notatek', 400);
        }
        return apiResponse(True, ['note' => $notes], 'Dodano notatki', 200);
    }

    public function addToReview(Request $request, Word $word)
    {
        $array = [];
        $success = (new UserWordsService)->addToReview($word, $request->user());
        $array['achievement'] = $success[0] ?? $success = [];
        $array['money'] = $request->user()->money;
        if(!$success) {return apiResponse(False, [], 'Nie udalo sie dodac do powtorek', 400);}
        else {return apiResponse(True, ['update' => $array], 'Dodano do powtorek', 200);}
    }

    public function revokeFromReview(Request $request, Word $word)
    {
        $success = (new UserWordsService)->revokeFromReview($word, $request->user());

        if(!$success) {return apiResponse(False, [], 'Nie udalo sie usunac z powtorek', 400);}
        else {return apiResponse(True, [], 'Usunieto z powtorek', 200);}
    }


    public function changeReviewStatus(changeReviewStatusRequest $request)
    {
        $status = $request->user()
            ->words()
            ->where('word__words.id','=',$request->id)
            ->first()
            ->pivot
            ->update(['review_done' => 1]);

        if($status) return apiResponse(true,[],'Pomyslnie wykonano powtorke',200);
        else apiResponse(true,[],'Wystapil problem',404);
    }

    public function refreshReviewStatus(CategoryReviewsRequest $request)
    {
        $category = Category::where('name', $request->category)->first()?->id;

        $reviews_model = $request->user()
            ->words()
            ->where('review', 1)
            ->where('review_done', 1)
            ->where('category_id', $category);
        $values = $reviews_model->get();
        $reviews = $values->toArray();
        $values = $values->pluck('id');
        $toUpdate = [];
        foreach($values as $id) {
            $toUpdate[$id] = ['review_done' => 0];
        }
        $request->user()->words()->syncWithoutDetaching($toUpdate);
        foreach($reviews as &$review)
        {
            unset($review['pivot']['user_id']);
            unset($review['pivot']['word_id']);
        }

        if($reviews) return apiResponse(True, $reviews, 'Odswiezono powtorki dla kategorii', 200);
        else return apiResponse(True, [], 'Nie udalo sie odswiezyc powtorek', 404);
    }

    public function categories_names_and_rep_amounts(Request $request)
    {
        $cat_amount = count(Category::all());
        $response = [];
        $reps_all = count($request->user()->words()->where('review',1)->where('review_done',0)->get());
        $response['reps_all_amount'] = $reps_all;
        $response['category'] = [];
        for($i=1;$i<=$cat_amount;$i++)
        {
            $category = Category::find($i);
            $rep_amount = $request->user()->words()->where('category_id',$i)
                ->where('review',1)->where('review_done',0)->count();
            $rep_amount_total = $request->user()->words()->where('category_id',$i)
                ->where('review',1)->count();
            $response['category'][] = [
                'category_name' => $category->name,
                'category_id' => $category->id,
                'rep_amount' => $rep_amount,
                'rep_total_amount' => $rep_amount_total,
            ];
        }

        return apiResponse(true, $response);
    }

}
