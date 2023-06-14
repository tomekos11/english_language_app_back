<?php

namespace Modules\System\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Modules\System\Entities\Achievement;

class AchievementSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $allData = "Bronze I-You took the first test of the day on Easy difficulty-50-1-easy_today|Bronze II-You took two tests that day on Easy difficulty-100-2-easy_today|Bronze III-You took three tests that day on Easy difficulty-200-3-easy_today|Bronze IV-You took five tests that day on Easy difficulty-500-5-easy_today|Silver I-You took the first test of the day on Medium difficulty-100-1-medium_today|Silver II-You took two tests that day on Medium difficulty-200-2-medium_today|Silver III-You took three tests that day on Medium difficulty-400-3-medium_today|Silver IV-You took five tests that day on Medium difficulty-1000-5-medium_today|Gold I-You took the first test of the day on Hard difficulty-150-1-hard_today|Gold II-You took two tests that day on Hard difficulty-300-2-hard_today|Gold III-You took three tests that day on Hard difficulty-600-3-hard_today|Gold IV-You took five tests that day on Hard difficulty-1500-5-hard_today|Favourite-Added the first words to favourites-50-1-favourite|Favourite I-You've added 10 words to favourites-100-10-favourite|Favourite II-You've added 20 words to favourites-200-20-favourite|Favourite III-You've added 50 words to favourites-500-50-favourite|Favourite IV-You've added 100 words to favorites-1000-100-favourite|Review-Added the first words to reviews-50-1-review|Review I-You've added 10 words to reviews-100-10-review|Review II-You've added 20 words to reviews-200-20-review|Review III-You've added 50 words to reviews-500-50-review|Review IV-You've added 100 words to reviews-1000-100-review|Platinum I-You took 10 tests on Easy difficulty-1000-10-easy_all|Platinum II-You took 15 tests on Easy difficulty-1500-15-easy_all|Platinum III-You took 20 tests on Easy difficulty-2000-20-easy_all|Master I-You took 10 tests on Medium difficulty-2000-10-medium_all|Master II-You took 15 tests on Medium difficulty-3000-15-medium_all|Master III-You took 20 tests on Medium difficulty-4000-20-medium_all|Challenger I-You took 10 tests on Hard difficulty-3000-10-hard_all|Challenger II-You took 15 tests on Hard difficulty-4500-15-hard_all|Challenger III-You took 20 tests on Hard difficulty-6000-20-hard_all|Collector-You collected a first heart-100-1-lifes|Collector I-You have collected 10 hearts-1000-10-lifes|Collector II-You have collected 15 hearts-1500-15-lifes|Collector III-You have collected 20 hearts-2000-20-lifes";


        $allData = explode("|", $allData);
        foreach ($allData as &$item) {
            $item = explode("-", $item);
            Achievement::create([
                'name' => $item[0],
                'description' => $item[1],
                'event_type' => $item[4],
                'value' => $item[3],
                'money' => $item[2],
                'photo_url' => Storage::url('achievements/'.str_replace(' ','_',$item[0]).'.svg'),
            ]);
        }


    }
}
