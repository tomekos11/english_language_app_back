<?php

namespace Modules\Auth\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;
use Modules\Word\Entities\Exercise;
use Modules\Word\Enums\TypeEnum;

class CreateExercises
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $types = [TypeEnum::PAIRS, TypeEnum::SENTENCES, TypeEnum::WORDS, TypeEnum::PUZZLE];
        $pair_id = 1;
        $sentence_id = 1;
        $puzzle_id = 1;
        foreach(DB::table('word__tests')->where('user_id','=',$event->user->id)->get() as $test)
        {
            $number = 1;

            //tworzenie laczen par
            for($i=0;$i<3;$i++)
            {
                Exercise::create([
                    'test_id' => $test->id,
                    'external_id' => $pair_id,
                    'status' => 0,
                    'type' => $types[0],
                    'number' => $number,
                ]);
                $pair_id++;
                $number++;
            }
            //tworzenie uzupelniania zdan
            for($i=0;$i<5;$i++)
            {
                Exercise::create([
                    'test_id' => $test->id,
                    'external_id' => $sentence_id,
                    'status' => 0,
                    'type' => $types[1],
                    'number' => $number,
                ]);
                $sentence_id++;
                $number++;
            }
            for($i=0;$i<3;$i++)
            {
                Exercise::create([
                    'test_id' => $test->id,
                    'external_id' => $puzzle_id,
                    'status' => 0,
                    'type' => $types[3],
                    'number' => $number,
                ]);
                $puzzle_id++;
                $number++;
            }
        }
    }
}
