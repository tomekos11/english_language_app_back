<?php

namespace Modules\System\Services;

use Modules\System\Entities\DailyUserLife;
use Illuminate\Support\Facades\DB;
use Modules\Auth\Entities\User;
use Modules\System\Entities\HeartUpdate;
use Modules\System\Http\Requests\DailyUserRequest;
use Modules\Word\Entities\Word;

class DailyUserLifeService
{

    public function addEveryoneHeart()
    {
        $heart_update = HeartUpdate::first();
        $everyones_lifes = DailyUserLife::where('life_count','<',10)->get();
        $heart_update->update(['updated_at' => now()]);

        foreach($everyones_lifes as $user_lifes)
        {
            $new_lifes = $user_lifes->life_count+1;
            $user_lifes->update(['life_count' => $new_lifes]);
        }
    }

    public function minus(User $user)
    {
        $new_lives = $user
            ->daily_user_life()
            ->first()
            ->life_count - 1 ;

        if($new_lives >= 0)
        {
            $success = $user->daily_user_life->update(['life_count' => $new_lives]);
            return $success;
        }

        return 0;
    }

    public function plus(User $user)
    {
        $new_lives = $user
            ->daily_user_life()
            ->first()
            ->life_count + 1 ;

        if($new_lives <= 20)
        {
            $success = $user->daily_user_life->update(['life_count' => $new_lives]);
            return $success;
        }

        return 0;
    }
    public function checkSpawnHeart(DailyUserRequest $request)
    {
        $response = $request->user()->daily_user_life->toArray();
        if(time() > $response['next_heart_unix_time']){
            $response['spawn_heart'] = 1;
            $rand_word = rand(1, 3000);
            if($rand_word % 2 == 0) {
                $response['translate_word'] = ['word' => Word::where('id', '=', $rand_word)->get()[0]['word_en'], 'word_language' => 'en'];
            }else{
                $response['translate_word'] = ['word' => Word::where('id','=',$rand_word)->get()[0]['word_pl'], 'word_language' => 'pl'];
            }
        }else{
            $response['spawn_heart'] = 0;
        }
        unset($response['next_heart_unix_time'], $response['id'], $response['user_id']);
        return $response;
    }
    public function checkAnswer(DailyUserRequest $request) : array
    {
        if(time() <= $request->user()->daily_user_life->toArray()['next_heart_unix_time']){
            return ['success' => 0, 'data' => [], 'message' => 'too_early'];
        }
        if($request->input('fail')){
            (new DailyUserLifeService)->updateSpawnTime($request->user());
            return ['success' => 1, 'data' => [], 'message' => 'ok'];
        }
        if($request->input('word_en') && $request->input('word_pl')){
            if($request->input('original_word_lan') == 'en'){
                $word = Word::where('word_en', '=', $request->input('word_en'))->get();
                if($word->first()->word_pl != $request->input('word_pl')) {
                    $this->updateSpawnTime($request->user());
                    return ['success' => 0, 'data' => ['status' => 'bad_answer', 'answer' => $word->first()->word_pl], 'message' => 'Bledna odpowiedz'];
                }
            }else{
                $word = Word::where('word_pl', '=', $request->input('word_pl'))->get();
                if($word->first()->word_en != $request->input('word_en')) {
                    $this->updateSpawnTime($request->user());
                    return ['success' => 0, 'data' => ['status' => 'bad_answer', 'answer' => $word->first()->word_en], 'message' => 'Bledna odpowiedz'];
                }
            }
        }else{
            if($request->input('word_en') === null){
                $word = Word::where('word_pl', '=', $request->input('word_pl'))->first();
                $this->updateSpawnTime($request->user());
                return ['success' => 0, 'data' => ['status' =>'no_answer','answer' => $word->word_en], 'message' => 'Brak odpowiedzi'];
            }
            else if($request->input('word_pl') === null){
                $word = Word::where('word_en', '=', $request->input('word_en'))->first();
                $this->updateSpawnTime($request->user());
                return ['success' => 0, 'data' => ['status' =>'no_answer','answer' => $word->word_pl], 'message' => 'Brak odpowiedzi'];
            }

        }
        $success = (new DailyUserLifeService)->plus($request->user());
        $lives = $request->user()->daily_user_life()->first()->life_count;
        if($success) {
            $this->updateSpawnTime($request->user());
            $request->user()->daily_user_life()->update(['total_collect_heart' => $request->user()->daily_user_life()->first()->total_collect_heart + 1]);
            return ['success' => 1, 'data' => ['life_amount' => $lives, 'status' => 'ok'], 'message' => 'Zyskales zycie'];
        }
        return ['success' => 0, 'data' => ['status' => 'error'], 'message' => 'Cos poszlo nie tak'];
    }
    public function updateSpawnTime(User $user){
        $randTime = rand(5, 20);
        $time = time();
        return $user->daily_user_life->update(['next_heart_unix_time' => $time + $randTime * 60]);
    }
}
