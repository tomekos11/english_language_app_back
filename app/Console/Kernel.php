<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Event;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Modules\System\Services\DailyUserLifeService;
use Modules\Word\Services\WordOfTheDayService;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */

    protected function schedule(Schedule $schedule)
    {
        #pick word of the day
        $schedule->command('pick')->cron('0 0 * * *');

        #add every 2 hours 1 heart to everyone
        $schedule->call(function () {
            (new DailyUserLifeService)->addEveryoneHeart();
        })->everyTwoHours();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
