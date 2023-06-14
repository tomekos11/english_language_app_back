<?php

namespace Modules\Word\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PairsPivotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $difficulties = ['easy','medium','hard'];
        $category_id = 1;
        $pair_id = 1;
        $liczba_zadan = 3;

        foreach(DB::table('word__categories')->get() as $category)
        {
            foreach($difficulties as $diff)
            {
                $word_id = DB::table('word__words')
                    ->where('category_id', '=', $category_id)
                    ->where('difficulty', '=', $diff)
                    ->first()->id;
                
                for($i = 0; $i < $liczba_zadan; $i++)
                {
                    $word_id_max = $word_id+5;
                    while($word_id < $word_id_max)
                    {
                        DB::table('word__pairs_words_pivot')->insert([
                            [
                                'word_id' => $word_id,
                                'pair_id' => $pair_id,
                            ]
                            ]);
                        $word_id++;
                    }
                    $pair_id++;
                }
            }
            $category_id++;
        }

    }
}
