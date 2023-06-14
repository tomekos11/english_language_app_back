<?php

namespace Modules\Word\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\System\Entities\Achievement;
use Modules\System\Services\ExpService;

class FavouriteAchievementListener
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
        $achievement_array = [];
        $achi = Achievement::where('event_type','=','favourite')
            ->get();
        $favourite_count = $event->user->favourite_counter;
        foreach($achi as $ach){
            if($favourite_count == $ach->value && !$event->user->achievements()->where('event_type','=','favourite')->where('value','=',$ach->value)->first()){
                array_push($achievement_array, $ach->name);
                $event->user->achievements()->attach($ach->id);
                $event->user->update(['money' => $event->user->money + $ach->money]);
                //xp update
                (new ExpService)->updateExp($event->user, $ach->money);
                $event->user->money_logs()->create([
                    'user_id' => $event->user->id,
                    'event' => 'AchievementReceived',
                    'value' => $ach->id,
                    'old_budget' => $event->user->money-$ach->money,
                    'new_budget' => $event->user->money,
                ]);
            }
        }
        return $achievement_array;
    }
}
