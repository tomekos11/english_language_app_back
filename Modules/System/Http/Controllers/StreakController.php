<?php

namespace Modules\System\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class StreakController extends Controller
{
    public function showLatestStreakInfo(Request $request)
    {
        $latest_streak = $request->user()->streak()->orderByDesc('updated_at')->first();
        if(is_null($latest_streak)) return apiResponse(false,[],'Nie posiadasz streakow',400);
        return apiResponse(true, [
            'count' => $latest_streak->count,
            'created_at' => $latest_streak->created_at->format('d-m-Y'),
            'last_refresh' => $latest_streak->updated_at->format('d-m-Y')],
            'Pomyslnie wyswietlono ostatni streak', 200);
    }

    public function showLongestStreakInfo(Request $request)
    {
        $longest_streak = $request->user()->streak()->orderByDesc('count')->first();
        if(is_null($longest_streak)) return apiResponse(false,[],'Nie posiadasz streakow',400);
        return apiResponse(true, [
            'count' => $longest_streak->count,
            'created_at' => $longest_streak->created_at->format('d-m-Y'),
            'last_refresh' => $longest_streak->updated_at->format('d-m-Y')],
            'Pomyslnie wyswietlono najdluzszy streak', 200);
    }

    public function showAllStreaks(Request $request)
    {
        $streaks = $request->user()->streak()->orderByDesc('count')->get();
        if(is_null($streaks)) return apiResponse(false,[],'Nie posiadasz streakow',400);
        return apiResponse(true, $streaks->toArray(),'Pomyslnie wyswietlono najdluzszy streak', 200);
    }
}
