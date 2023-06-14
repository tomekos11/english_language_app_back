<?php

namespace Modules\System\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\System\Entities\Achievement;
use Modules\System\Http\Requests\DailyUserRequest;

class UserAchievementController extends Controller
{
    public function index_users_achievements(DailyUserRequest $request)
    {
        $allAchievements = Achievement::all()->toArray();
        $achievements = $request->user()->achievements()->get()?->pluck('id')?->toArray();
        foreach($allAchievements as $key => $ach) {
            if(in_array($ach['id'], $achievements)) {
                $allAchievements[$key]['has'] = true;
            } else {
                $allAchievements[$key]['has'] = false;
            }
        }

        if (!$allAchievements) {
            return apiResponse(false, [], 'Nie udalo sie wyswietlic achievementow uzytkownika', 404);
        } else {
            return apiResponse(true, $allAchievements, 'Wyswietlono achievementy uzytkownika', 200);
        }
    }

}
