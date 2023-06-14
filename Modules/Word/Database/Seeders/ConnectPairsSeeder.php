<?php

namespace Modules\Word\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Word\Entities\ConnectPairs;
use Illuminate\Support\Facades\DB;

class ConnectPairsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(DB::table('word__categories')->get() as $category)
        {
            //kazda kategoria ma 3 poziomy trudnosci i kazdy z nich po 3 laczenia wyrazow wiec 3x3 = 9
            for($i=0;$i<9;$i++)
            {
                ConnectPairs::create([]);
            }
        }
        
    }
}
