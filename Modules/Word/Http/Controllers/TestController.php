<?php

namespace Modules\Word\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\System\Services\DailyUserLifeService;
use Modules\Word\Enums\TypeEnum;
use Modules\Word\Events\TestDone;
use Modules\Word\Http\Requests\CheckAnswerRequest;
use Modules\Word\Services\TestService;
use Modules\Word\Services\UpdateStreak;

class TestController extends Controller
{
    public function index(Request $request)
    {
        $success = (new TestService)->index($request->user());

        return apiResponse(True, $success, 'Zwrocono testy uzytkownika', 200);
    }

    public function showExercises(int $nr_testu, Request $request)
    {
        $excercises = $request->user()
            ->tests()
            ->where('number','=',$nr_testu)
            ->firstOrFail()
            ->exercises()
            ->get()
            ->toArray();

        return apiResponse(True, $excercises, 'Zwrocono zadania dla testu', 200);
    }

    public function showExercise(int $nr_testu, int $nr_zadania, Request $request)
    {
        $exercises = $request->user()
        ->tests()
        ->where('number','=',$nr_testu)
        ->firstOrFail()
        ->exercises()
        ->where('number','=',$nr_zadania)
        ->firstOrFail();

        if($exercises->type == TypeEnum::SENTENCES)
        {
            $exercise = $exercises->external()
            ->firstOrFail()
            ->toArray();
        }

        if($exercises->type == TypeEnum::PAIRS)
        {
            $exercise = $exercises->external()
            ->firstOrFail()
            ->words()
            ->get()
            ->toArray();
        }

        if($exercises->type == TypeEnum::PUZZLE)
        {
            $exercise = $exercises
                ->external()
                ->get()
                ->toArray();
        }
        return apiResponse(True, $exercise, 'Zwrocono zadania dla testu', 200);
    }

    public function checkAnswer(CheckAnswerRequest $request, int $nr_testu, int $nr_zadania)
    {
        $lives = $request->user()->daily_user_life()->first()->life_count;

        if($lives <= 0)
        {
            return apiResponse(False, [], 'Nie masz odpowiedniej ilosci żyć', 200);
        }

        $test = $request->user()
        ->tests()
        ->where('number','=',$nr_testu)
        ->firstOrFail();

        $exercises = $test
        ->exercises()->get();

        $exercise = $exercises
            ->where('number','=',$nr_zadania)
            ->firstOrFail();

        if($test->status == 1)
        {
            return apiResponse(False, ['performance_date' => $test->updated_at->format('d-m-Y'),], 'Test zostal juz wykonany', 200);
        }

        if($exercise->status == 1)
        {
            return apiResponse(False, ['performance_date' => $exercise->updated_at->format('d-m-Y')], 'Zadanie zostalo juz wykonane', 200);
        }

        if($exercise->type == TypeEnum::SENTENCES)
        {
            $exercise_data = $exercise->external()
            ->firstOrFail();

            if($exercise_data->correct_answer == $request->answer_fill_sentence)
            {
                $exercise->update(['status' => 1]);
                (new UpdateStreak)->Update($request->user());

                $ex_amount = count($test->exercises()->get());
                $done_test_amount = count($test->exercises()->where('status','=',1)->get());

                if($ex_amount == $done_test_amount)
                {
                    $test->update(['status' => 1]);
                    $array['achievement'] = event(new TestDone($request->user(), $test))[0];
                    $array['money'] = $request->user()->money;
                    return apiResponse(True, ['word' => $request->answer_fill_sentence, 'update'=> $array], 'Dobra odpowiedz. Test zostal zakończony pomyslnie', 200);
                }
                $array['achievement'] = [];
                $array['money'] = $request->user()->money;
                return apiResponse(True, ['word' => $request->answer_fill_sentence, 'update'=> $array], 'Dobra odpowiedz', 200);
            }
            //if answer is wrong
            (new DailyUserLifeService)->minus($request->user());
            return apiResponse(False, [
                'word' => $request->answer_fill_sentence,
                'life_amount' => $lives-1,
            ], 'Niepoprawna odpowiedz. Tracisz zycie', 200);
        }

        if($exercise->type == TypeEnum::PAIRS)
        {
            //exercise download
            $exercise_data = $exercise->external()
            ->firstOrFail()
            ->words()
            ->get();
            //user request decoding
            $pairs_array = json_decode($request->pairs,true);


            for($i=0; $i<count($pairs_array); $i++) {
                for($j=$i+1; $j<count($pairs_array); $j++) {
                    if (
                        $pairs_array[$i]["word_pl"] == $pairs_array[$j]["word_pl"]
                        && $pairs_array[$i]["word_en"] == $pairs_array[$j]["word_en"]
                    ) {
                        //if any repetitions - cheating
                        (new DailyUserLifeService)->minus($request->user());
                        return apiResponse(False, [
                            'life_amount' => $lives-1,
                            'pairs' => $pairs_array,
                            ], 'Cheating. Tracisz Zycie', 200);
                    }
                }
            }

            $correct_answer_counter = 0;
            foreach($pairs_array as $pair) {
                foreach($exercise_data as $ex) {
                    if ($pair["word_pl"] == $ex->word_pl && $pair["word_en"] == $ex->word_en) {
                        $correct_answer_counter++;
                        break;
                    }
                }
            }

            //if every answer is correct = you passed
            if($correct_answer_counter == $exercise_data->count() && count($pairs_array) == $exercise_data->count()) {
                $exercise->update(['status' => 1]);
                (new UpdateStreak)->Update($request->user());

                $ex_amount = count($test->exercises()->get());
                $done_test_amount = count($test->exercises()->where('status','=',1)->get());

                if($ex_amount == $done_test_amount) {
                    $test->update(['status' => 1]);
                    $array['achievement'] = event(new TestDone($request->user(), $test))[0];
                    $array['money'] = $request->user()->money;
                    return apiResponse(True, ['pairs' => $pairs_array, 'update'=> $array], 'Poprawnie polaczyles wszystkie. Test zostal zakończony pomyslnie', 200);
                }
                $array['achievement'] = [];
                $array['money'] = $request->user()->money;
                return apiResponse(True, ['pairs' => $pairs_array, 'update'=> $array], 'Poprawnie polaczyles wszystkie pary', 200);
            }

            //if current answer if correct then
            if($correct_answer_counter == count($pairs_array)) {
                return apiResponse(True, ['pairs' => $pairs_array,], 'Poprawnie polaczyles pare', 200);
            }


            (new DailyUserLifeService)->minus($request->user());
            return apiResponse(False, [
                'life_amount' => $lives-1,
                'pairs' => $pairs_array,
                'count' => count($pairs_array),
            ], 'Niepoprawnie polaczyles pare. Tracisz Zycie', 200);

        }
        if($exercise->type == TypeEnum::PUZZLE)
        {
            $exercise_answer= $exercise->external()->firstOrFail()->correct_answer;
            $user_answer = json_decode($request->answer);

            if(count($exercise_answer) == count($exercise_answer)){
                for($i = 0; $i < count($exercise_answer); $i++){
                    if($exercise_answer[$i] != $user_answer[$i]){
                        (new DailyUserLifeService)->minus($request->user());
                        return apiResponse(False, ['answer' => $exercise_answer, 'status' => '0'], 'Niepoprawna odpowiedz. Tracisz zycie.', 200);
                    }
                }
            }

            $exercise->update(['status' => 1]);
            (new UpdateStreak)->Update($request->user());
            $ex_amount = count($test->exercises()->get());
            $done_test_amount = count($test->exercises()->where('status','=',1)->get());
            if($ex_amount == $done_test_amount)
            {
                $test->update(['status' => 1]);
                $array['achievement'] = event(new TestDone($request->user(), $test))[0];
                $array['money'] = $request->user()->money;
                return apiResponse(True, ['answer' => $exercise_answer, 'update'=> $array], 'Poprawna kolejność. Test został zakończony pomyślnie', 200);
            }
            $array['achievement'] = [];
            $array['money'] = $request->user()->money;
            return apiResponse(True, ['answer' => $exercise_answer, 'update'=> $array], 'Poprawna kolejność', 200);
        }
    }

}
