<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Auth\Entities\User;
use Modules\System\Entities\TimeGames;
use Modules\System\Enums\GameTypeEnum;

class RankingController extends Controller
{

    public function rankingByMoney(Request $request)
    {
        $user_data_money = User::with('data')->orderByRaw('money DESC')->get()->map(function($user) {
            $relatedData = $user->data;
            return [
                'name' => $relatedData->name,
                'surname' => $relatedData->surname,
                'value' => $user->money,
            ];
        });
        return apiResponse(true, $user_data_money->toArray(),'Pomyslnie zwrocono ranking graczy - money',200);
        //return apiResponse(true, User::orderByDesc('money')->get()->toArray(),'Pomyslnie zwrocono ranking graczy - money',200);
    }
    public function rankingByLvl(Request $request){
        $user_data_money = User::with('data')->orderByRaw('lvl DESC')->get()->map(function($user) {
            $relatedData = $user->data;
            return [
                'name' => $relatedData->name,
                'surname' => $relatedData->surname,
                'value' => $user->lvl,
            ];
        });
        return apiResponse(true, $user_data_money->toArray(),'Pomyslnie zwrocono ranking graczy - lvl',200);
    }
    public function rakingBy15s(Request $request)
    {
        /*$users_by_15s_points = TimeGames::where('type',GameTypeEnum::QUARTER_MINUTE->value)
            ->select('user_id', DB::raw('MAX(result) as max_result'))
            ->groupBy('user_id')
            ->orderByRaw('result DESC, id ASC')
            ->get()->toArray();

        return apiResponse(true, $users_by_15s_points,'Pomyslnie zwrocono ranking graczy - 15s',200);
        */
        $users_by_15s_points = User::all()->load(['data', 'time_games' => function($query){
            $query->select('user_id', 'type', DB::raw('MAX(result) as best_result'))->groupBy('user_id', 'type');
        }])->map(function($user){
            return [
                'name' => $user->data->name,
                '15s' => $user->time_games->where('type', GameTypeEnum::QUARTER_MINUTE)->max('best_result'),
            ];
        })->toArray();
        return apiResponse(true, $users_by_15s_points,'Pomyslnie zwrocono ranking graczy - 15s',200);
    }

    public function rakingBy30s(Request $request)
    {
        /*$users_by_30s_points = TimeGames::where('type',GameTypeEnum::HALF_MINUTE->value)
            ->select('user_id', DB::raw('MAX(result) as max_result'))
            ->groupBy('user_id')
            ->orderByRaw('result DESC, id ASC')
            ->get()->toArray();

        return apiResponse(true, $users_by_30s_points,'Pomyslnie zwrocono ranking graczy - 15s',200);*/
        $users_by_30s_points = User::all()->load(['data', 'time_games' => function($query){
            $query->select('user_id', 'type', DB::raw('MAX(result) as best_result'))->groupBy('user_id', 'type');
        }])->map(function($user){
            return [
                'name' => $user->data->name,
                '30s' => $user->time_games->where('type', GameTypeEnum::HALF_MINUTE)->max('best_result'),
            ];
        })->toArray();
        return apiResponse(true, $users_by_30s_points,'Pomyslnie zwrocono ranking graczy - 30s',200);
    }

    public function rakingBy60s(Request $request)
    {
        /*$users_by_60s_points = TimeGames::where('type',GameTypeEnum::ONE_MINUTE->value)
            ->select('user_id', DB::raw('MAX(result) as max_result'))
            ->groupBy('user_id')
            ->orderByRaw('result DESC, id ASC')
            ->get()->toArray();

        return apiResponse(true, $users_by_60s_points,'Pomyslnie zwrocono ranking graczy - 15s',200);
        */
        $users_by_60s_points = User::all()->load(['data', 'time_games' => function($query){
            $query->select('user_id', 'type', DB::raw('MAX(result) as best_result'))->groupBy('user_id', 'type');
        }])->map(function($user){
            return [
                'name' => $user->data->name,
                '60s' => $user->time_games->where('type', GameTypeEnum::ONE_MINUTE)->max('best_result'),
            ];
        })->toArray();
        return apiResponse(true, $users_by_60s_points,'Pomyslnie zwrocono ranking graczy - 60s',200);

    }
    public function rakingAll(Request $request)
    {
        $allData = User::all()->load(['data', 'time_games' => function($query){
            $query->select('user_id', 'type', DB::raw('MAX(result) as best_result'))->groupBy('user_id', 'type');
        }])->map(function($user){
            return [
                'name' => $user->data->name,
                'surname' => $user->data->surname,
                'money' => $user->money,
                'lvl' => $user->lvl,
                '15s' => $user->time_games->where('type', GameTypeEnum::QUARTER_MINUTE)->max('best_result'),
                '30s' => $user->time_games->where('type', GameTypeEnum::HALF_MINUTE)->max('best_result'),
                '60s' => $user->time_games->where('type', GameTypeEnum::ONE_MINUTE)->max('best_result'),
                ];
        })->toArray();
        return apiResponse(true, $allData,'Pomyslnie zwrocono ranking graczy',200);
    }
}
