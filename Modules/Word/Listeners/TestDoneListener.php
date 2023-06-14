<?php

namespace Modules\Word\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\System\Entities\Achievement;
use Modules\Word\Enums\DifficultyEnum;
use Modules\System\Services\ExpService;
class TestDoneListener
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
     * @return array
     */
    public function handle($event)
    {
        $achievements_earned = [];
        $user = $event->user;
        $diff = $event->test->difficulty;

        //reward for test
        switch($diff)
        {
            case 'easy' : $reward = 50; break;
            case 'medium' : $reward = 100; break;
            case 'hard' : $reward = 200; break;
        }

        //money update
        $user->update([
            'money' => $user->money+$reward,
        ]);

        //xp update
        (new ExpService)->updateExp($user, $reward);
        //create logs
        $user->money_logs()->create([
            'user_id' => $user->id,
            'event' => 'TestDone',
            'value' => $event->test->id,
            'old_budget' => $user->money-$reward,
            'new_budget' => $user->money,
        ]);

        //achievements

        $done_diff_test_amount = count($user->tests()
            ->where('status','=',1)
            ->where('difficulty','=',$diff)->get());

        $done_diff_test_amount_today = count($user->tests()
        ->where('status','=',1)
        ->where('difficulty','=',$diff)
        ->whereDate('updated_at',today())->get());

        $daily_amounts = Achievement::where('event_type','=','easy_today')->distinct()->pluck('value');
        $all_amounts = Achievement::where('event_type','=','easy_all')->distinct()->pluck('value');

        foreach($daily_amounts as $daily_amount)
        {
            if($done_diff_test_amount_today === $daily_amount)
            {
                $achievement = Achievement::where('event_type','=',$diff.'_today')
                ->where('value','=', $done_diff_test_amount_today)->first();
                array_push($achievements_earned, $achievement->name);
                $reward = $achievement->money;
                //attach daily achievement - user to the pivot
                $user->achievements()->attach($achievement->id);

                //reward for achievement
                $user->update(['money' => $user->money+$reward]);
                //xp update
                (new ExpService)->updateExp($user, $reward);
                $user->money_logs()->create([
                    'user_id' => $user->id,
                    'event' => 'AchievementReceived',
                    'value' => $achievement->id,
                    'old_budget' => $user->money-$reward,
                    'new_budget' => $user->money,
                    ]);
            }
        }

        foreach($all_amounts as $all_amount)
        {
            if($done_diff_test_amount === $all_amount)
            {
                $achievement = Achievement::where('event_type','=',$diff.'_all')
                ->where('value','=', $done_diff_test_amount)->first();
                array_push($achievements_earned, $achievement->name);
                $reward = $achievement->money;
                //attach achievement - user to the pivot
                $user->achievements()->attach($achievement->id);

                //reward for achievement
                $user->update(['money' => $user->money+$reward]);
                //xp update
                (new ExpService)->updateExp($user, $reward);
                $user->money_logs()->create([
                    'user_id' => $user->id,
                    'event' => 'AchievementReceived',
                    'value' => $achievement->id,
                    'old_budget' => $user->money-$reward,
                    'new_budget' => $user->money,
                ]);
            }
        }
        return $achievements_earned;
    }
}
