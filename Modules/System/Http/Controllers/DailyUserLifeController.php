<?php

namespace Modules\System\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\System\Events\GetHeart;
use Modules\System\Http\Requests\DailyUserRequest;
use Modules\System\Services\DailyUserLifeService;
use Modules\Word\Entities\Word;

class DailyUserLifeController extends Controller
{
    public function show(DailyUserRequest $request)
    {
        $response = (new DailyUserLifeService)->checkSpawnHeart($request);
        return apiResponse(True, $response, 'Zwrocono zycia uzytkownika', 200);
    }

   public function minusLife(DailyUserRequest $request)
   {
    $success = (new DailyUserLifeService)->minus($request->user());

    $lives = $request->user()->daily_user_life()->first()->life_count;

    if($success) return apiResponse(True,['life_amount' => $lives],'Straciles zycie', 200);
       return apiResponse(False, ['status', 'error'],'Nie udalo sie', 200);
   }

   public function plusLife(DailyUserRequest $request)
   {
       $array = [];
       $data = (new DailyUserLifeService)->checkAnswer($request);
       $array['achievement'] = event(new GetHeart($request->user()))[0];
       $array['money'] = $request->user()->money;
       $data['data']['update'] = $array;
       return apiResponse($data['success'], $data['data'], $data['message'], 200);
   }
}
