<?php

namespace Modules\Auth\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;

class CreateTests
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

        $counter = 1;
        $number = 1;
        foreach(DB::table('word__categories')->get() as $category)
        {
            $event->user->tests()->create([
                'category_id' => $counter,
                'status' => false,
                'difficulty' => 'easy',
                'number' => $number,
            ]);
            $number++;
            
            $event->user->tests()->create([
                'category_id' => $counter,
                'status' => false,
                'difficulty' => 'medium',
                'number' => $number,
            ]);
            $number++;

            $event->user->tests()->create([
                'category_id' => $counter,
                'status' => false,
                'difficulty' => 'hard',
                'number' => $number,
            ]);
            $number++;

            $counter++;
        }
    }
}