<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\System\Database\Seeders\AchievementSeederTableSeeder;
use Modules\System\Database\Seeders\HeartUpdateSeeder;
use Modules\Word\Database\Seeders\CategoryTableSeeder;
use Modules\Word\Database\Seeders\WordTableSeeder;
use Modules\Word\Database\Seeders\ConnectPairsSeeder;
use Modules\Word\Database\Seeders\PairsPivotSeeder;
use Modules\Word\Database\Seeders\FillSentencesSeeder;
use Modules\Word\Database\Seeders\PuzzleTableSeeder;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //\App\Models\User::factory(10)->create();
        $this->call(CategoryTableSeeder::class);
        $this->call(WordTableSeeder::class);
        $this->call(ConnectPairsSeeder::class);
        $this->call(PairsPivotSeeder::class);
        $this->call(FillSentencesSeeder::class);
        $this->call(AchievementSeederTableSeeder::class);
        $this->call(PuzzleTableSeeder::class);
        $this->call(HeartUpdateSeeder::class);
    }
}
