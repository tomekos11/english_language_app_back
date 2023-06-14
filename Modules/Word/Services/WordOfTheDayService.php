<?php

namespace Modules\Word\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Modules\Word\Entities\Word;
use Symfony\Component\Console\Output\ConsoleOutput;

class WordOfTheDayService
{

    public function choose()
    {
        
        $word_with_images_ids = Word::where('photo_url','!=', '')->pluck('id')->toArray();

        if(date('Y-m-d') !== Cache::get('word_of_the_day_date')) {
            do {
                $randomKey = array_rand($word_with_images_ids);
                $randed = $word_with_images_ids[$randomKey];
            } while(Word::where('id', $randed)->count() === 0);

            Cache::put('word_of_the_day_id', $randed);
            Cache::put('word_of_the_day_date', date('Y-m-d'));

            error_log('Word of the day ID: ' . Cache::get('word_of_the_day_id'));
            return 0;
        }
        return 0;
    }




}
