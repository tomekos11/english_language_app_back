<?php

namespace Modules\System\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Modules\System\Entities\TimeGames;
use Modules\System\Http\Requests\DownloadWordsRequest;
use Modules\Word\Entities\Word;

class TimeGamesController extends Controller
{
   public function downloadWords(DownloadWordsRequest $request)
   {
        $user = $request->user();
        $type = $request->type;
        
        $indexes = [];
        $words_list = [];
        $translate_words = [];
        for($i=0;$i<55;$i++)
        {
            $random_int = rand(1,3000);
            while(in_array($random_int, $indexes))
            {
                $random_int = rand(1,3000);
            }
            $indexes[] = $random_int;
            $translate_words[] = Word::where('id',$random_int)->first()->word_en;
            $words_list[] = 
                ['word_en' => Word::where('id',$random_int)->first()->word_en,
                'word_pl' => Word::where('id',$random_int)->first()->word_pl];
        }

        Cache::put($user->id.'words_list',$words_list,120);
        Cache::put($user->id.'tries',0,120);
        switch($type)
        {
            case '15s': $time = 15; break;
            case '30s': $time = 30; break;
            case '60s': $time = 60; break;
        }

        $end_time = Carbon::createFromTimestamp(time()+$time)->format('Y-m-d H:i:s');
        $game_record = TimeGames::create([
            'user_id' => $user->id,
            'type' => $type,
            'result' => 0,
            'end_time' => $end_time,
        ]);
        
        $wyzwanie['translate_words'] = $translate_words;
        $wyzwanie['start_time'] = $game_record->created_at;
        $wyzwanie['end_time'] = $game_record->end_time;
        $wyzwanie['type'] = $game_record->type;

        return apiResponse(true,$wyzwanie,'Zaczeto wyzwanie ',200);
   }

   public function sendWord(Request $request)
   {
        $user = $request->user();
        $arrival_time = now();
        $word = $request->word;
        $game_record = $request->user()->time_games()
            ->where('type',$request->type)->orderByDesc('created_at')->first();
        $correct = false;
        if($game_record == null) return apiResponse(false,[],'Nie rozpoczales jeszcze gry',400);
        $old_result = $game_record->result;
        $answers_amount = Cache::get($user->id.'tries');
        if($answers_amount >= 54){
            return apiResponse(false,['last_try_points' => $game_record->result, 'type' => $request->type],'Odpowiedziales juz na wszystkie slowa', 200);
        }

        if($arrival_time >= $game_record->created_at &&
        $arrival_time <= $game_record->end_time)
        {
            if($word == Cache::get($user->id.'words_list')[$answers_amount]['word_pl']){
                $game_record->update([
                    'result' => $old_result+1,
                ]);
                $correct = true;
            }
            $answers_amount++;

            Cache::put($user->id.'tries',$answers_amount,120);
            return [
            'czy_poprawna_odp' => $correct,
            'correct_word' => Cache::get($user->id.'words_list')[$answers_amount-1]['word_pl'],
            'liczba_odp' => $answers_amount,
            'next_slowko_do_zg.' => Cache::get($user->id.'words_list')[$answers_amount]['word_en'],
            'liczba_pkt' => $game_record->result,
            'time_to_end' => $game_record->end_time->timestamp - $arrival_time->timestamp];
        }
        return apiResponse(false,['last_try_points' => $game_record->result, 'type' => $request->type],'Czas sie skonczyl', 200);
        
   }

   public function history(DownloadWordsRequest $request)
   {
        $game_records = $request->user()->time_games()
            ->where('type', $request->type)->get()->toArray();

        return apiResponse(true, $game_records,'Zwrocono wyniki gry uzytkownika',200);
   }
}
