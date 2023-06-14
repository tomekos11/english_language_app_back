<?php

namespace Modules\System\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\System\Entities\Achievement;

class CollectHearthListener
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
        $arr = [];
        $achi = Achievement::where('event_type','=','lifes')
            ->get();
        $heart = $event->user->daily_user_life()->first()->total_collect_heart;
        foreach($achi as $ach){
            if($heart === $ach->value && !$event->user->achievements()->where('event_type','=','lifes')->where('value','=',$ach->value)->first())
            {
                array_push($arr, $ach->name);
                $event->user->achievements()->attach($ach->id);
                $event->user->update(['money' => $event->user->money + $ach->money]);
                $event->user->money_logs()->create([
                    'user_id' => $event->user->id,
                    'event' => 'AchievementReceived',
                    'value' => $ach->id,
                    'old_budget' => $event->user->money-$ach->money,
                    'new_budget' => $event->user->money,
                ]);
            }
        }
        return $arr;
    }
}
