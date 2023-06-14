<?php

namespace Modules\Word\Services;

use Carbon\Carbon;
use Modules\Auth\Entities\User;

class UpdateStreak
{
    public function Update(User $user)
    {
        //streak
        $yesterday_streak = $user->streak()->orderByDesc('updated_at')
            ->whereDate('updated_at',Carbon::yesterday())->first();
        $user_tests = $user->tests()->get();
        $ex_done_amount = 0;

        foreach($user_tests as &$user_test)
        {
            $ex_done_amount += $user_test->exercises()->where('status','=',1)
                ->whereDate('updated_at','=',today())->get()->count();
        }
        if($ex_done_amount >1)
        {
            return apiResponse(false, ['exercises_done_today' => $ex_done_amount],'Streak juz dzis zostal odswiezony');
        }
        else if(is_null($user->streak()->first()) || is_null($yesterday_streak))
        {
            $user->streak()->create(['count' => 1]);
        }
        else if(!is_null($yesterday_streak))
        {
            $yesterday_streak->update(['count' => $yesterday_streak->count + 1]);
        }

    }


}
