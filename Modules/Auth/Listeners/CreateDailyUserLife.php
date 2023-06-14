<?php

namespace Modules\Auth\Listeners;

class CreateDailyUserLife
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
        $event->user->daily_user_life()->create([
            'life_count' => 5,
            'total_collect_heart' => 0,
            'next_heart_unix_time' => time() + 3600,
        ]);
    }
}
