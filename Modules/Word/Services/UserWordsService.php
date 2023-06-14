<?php

namespace Modules\Word\Services;

use Illuminate\Support\Facades\DB;
use Modules\Auth\Entities\User;
use Modules\Word\Entities\Word;
use Modules\Word\Events\FavouriteAchievement;
use Modules\Word\Events\ReviewAchievement;
class UserWordsService
{
    public function addToFavourite(Word $word, User $user)
    {
        $arr = [];
        $e = $user->words()->where('word__words.id', '=', $word->id)->first();
        $success = $user->words()->syncWithoutDetaching(['word_id' => $word->id]);
        $user->words()->updateExistingPivot($word->id, ['is_favourite' => 1]);
        if(is_null($e) || !$e->pivot->is_favourite) {
            $user->update(['favourite_counter' => $user->favourite_counter + 1]);
            $arr = event(new FavouriteAchievement($user));
        }
        return $arr;
    }

    public function revokeFromFavourite(Word $word, User $user)
    {
        $e = $user->words()->where('word__words.id', '=', $word->id)->first();
        $success = $user->words()->syncWithoutDetaching(['word_id' => $word->id]);
        $user->words()->updateExistingPivot($word->id, ['is_favourite' => 0]);
        if($e->pivot->is_favourite && $user->favourite_counter >= 0){
            $user->update(['favourite_counter' => $user->favourite_counter - 1]);
        }
        return $success;
    }

    public function addNote( string | null $notes, Word $word, User $user)
    {
        $success = $user->words()->syncWithoutDetaching(['word_id' => $word->id]);
        $user->words()->updateExistingPivot($word->id, ['notes' => $notes]);
        return $success;

    }

    public function addToReview(Word $word, User $user)
    {
        $arr = [];
        $e = $user->words()->where('word__words.id', '=', $word->id)->first();
        $success = $user->words()->syncWithoutDetaching(['word_id' => $word->id]);
        $user->words()->updateExistingPivot($word->id, ['review' => 1]);
        if(is_null($e) || !$e->pivot->review) {
            $user->update(['review_counter' => $user->review_counter + 1]);
            $arr = event(new ReviewAchievement($user));
        }
        return $arr ?? $success;

    }

    public function revokeFromReview(Word $word, User $user)
    {

        $success = $user->words()->syncWithoutDetaching(['word_id' => $word->id]);
        $user->words()->updateExistingPivot($word->id, ['review' => 0]);

        return $success;

    }
}
