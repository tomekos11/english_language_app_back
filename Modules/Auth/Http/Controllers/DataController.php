<?php

namespace Modules\Auth\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\Auth\Entities\User;
use Modules\Auth\Http\Requests\DataMeRequest;
use Modules\System\Entities\Achievement;
use Modules\System\Entities\TimeGames;
use Modules\System\Enums\GameTypeEnum;
use Modules\Word\Entities\Word;
use Illuminate\Http\UploadedFile;
use Modules\Auth\Http\Requests\ChangeDataRequest;
use Modules\System\Entities\HeartUpdate;
use Modules\Word\Entities\Test;

class DataController extends Controller
{
    public function me(DataMeRequest $request)
    {
        return apiResponse(true, array_merge($request->user()->data->toArray(), ['role' => $request->user()->role, 'money' => $request->user()->money]));
    }

    public function changeAvatar(DataMeRequest $request)
    {
        $acceptable_extensions = ['jpg','png','gif','svg', 'jpeg'];

        $file = $request->avatar;
        $fileExtension = $file->getClientOriginalExtension();

        if(!in_array($fileExtension,$acceptable_extensions)) return apiResponse(false,[],'Zly format pliku.',400);
        $user_id = $request->user()->id;
        $file->storeAs('public/users/avatars/',$user_id.'.'.$fileExtension);
        $request->user()->data()->update(['photo_url' => Storage::url('users/avatars/').$user_id.'.'.$fileExtension]);
        return apiResponse(true,[],'Poprawnie ustawiono zdjecie profilowe',200);
    }

    public function changeData(ChangeDataRequest $request)
    {
        $done = $request->user()->data()->update([
            'name' => $request->name,
            'surname' => $request->surname,
            'birth_date' => $request->birth_date,
        ]);

        if($done)
            return apiResponse(true,[],'Udalo sie zmienic dane',200);
        else
        return apiResponse(false,[],'Nie udalo sie zmienic danych',401);

    }

    public function dashboardData(DataMeRequest $request)
    {
        $user_data = $request->user()->toArray();

        $last_favourite_word = $request->user()->words()
            ->where('is_favourite',1)->orderBy('created_at');


        //ranking money
        $users_by_money = User::orderByRaw('money DESC, id ASC')->get();
        $counter = 1;
        foreach($users_by_money as &$user_by_money) {
            if ($user_by_money->id == $request->user()->id) {
                $user_data['ranking_by_money'] = $counter;
                break;
            }
            $counter++;
        }
        $user_data['ranking_by_money_short'] = $users_by_money->take(5)->load('data')->map(function($user) {
            $relatedData = $user->data;
            return [
                'name' => $relatedData->name,
                'surname' => $relatedData->surname,
                'value' => $user->money,
            ];
        });

        //ranking 15s
        $users_by_15s_points = TimeGames::where('type',GameTypeEnum::QUARTER_MINUTE->value)
            ->select('user_id', DB::raw('MAX(result) as max_result'))
            ->groupBy('user_id')
            ->orderByRaw('result DESC, id ASC')
            ->get();
        $counter = 1;
        foreach($users_by_15s_points as &$user_15s)
        {
            if($user_15s->user_id == $request->user()->id)
            {
                $user_data['ranking_by_15s'] = $counter;
                break;
            }
            $counter++;
        }
        $user_data['ranking_by_15s_short'] = $users_by_15s_points = TimeGames::where('type',GameTypeEnum::QUARTER_MINUTE->value)
            ->orderByRaw('result DESC, id ASC')
            ->take(5)
            ->with('users.data')
            ->get()
            ->map(function($user) {
            $relatedData = $user->users->data;
            return [
                'name' => $relatedData->name,
                'surname' => $relatedData->surname,
                'value' => $user->result,
            ];
        });
        //ranking 30s
        $users_by_30s_points = TimeGames::where('type',GameTypeEnum::HALF_MINUTE->value)
            ->select('user_id', DB::raw('MAX(result) as max_result'))
            ->groupBy('user_id')
            ->orderByRaw('result DESC, id ASC')
            ->get();

        $counter = 1;
        foreach($users_by_30s_points as &$user_30s)
        {
            if($user_30s->user_id == $request->user()->id)
            {
                $user_data['ranking_by_30s'] = $counter;
                break;
            }
            $counter++;
        }
        $user_data['ranking_by_30s_short'] = $users_by_15s_points = TimeGames::where('type',GameTypeEnum::HALF_MINUTE->value)
            ->orderByRaw('result DESC, id ASC')
            ->take(5)
            ->with('users.data')
            ->get()
            ->map(function($user) {
                $relatedData = $user->users->data;
                return [
                    'name' => $relatedData->name,
                    'surname' => $relatedData->surname,
                    'value' => $user->result,
                ];
            });
        //ranking 60s
        $users_by_60s_points = TimeGames::where('type',GameTypeEnum::ONE_MINUTE->value)
            ->select('user_id', DB::raw('MAX(result) as max_result'))
            ->groupBy('user_id')
            ->orderByRaw('result DESC, id ASC')
            ->get();

        $counter = 1;
        foreach($users_by_60s_points as &$user_60s)
        {
            if($user_60s->user_id == $request->user()->id)
            {
                $user_data['ranking_by_60s'] = $counter;
                break;
            }
            $counter++;
        }
        $user_data['ranking_by_60s_short'] = $users_by_15s_points = TimeGames::where('type',GameTypeEnum::ONE_MINUTE->value)
            ->orderByRaw('result DESC, id ASC')
            ->take(5)
            ->with('users.data')
            ->get()
            ->map(function($user) {
                $relatedData = $user->users->data;
                return [
                    'name' => $relatedData->name,
                    'surname' => $relatedData->surname,
                    'value' => $user->result,
                ];
            });
        $user_data['achievements_amount'] = count(Achievement::all());
        $user_data['user_achievements_amount'] = count($request->user()->achievements()->get());
        $user_data['last_favourite_word'] =
            ['word_pl' => $last_favourite_word->first()?->word_pl,
            'word_en' => $last_favourite_word->first()?->word_en];
        $user_data['word_of_the_day'] =
            ['word_pl' => Word::where('id',Cache::get('word_of_the_day_id'))->first()?->word_pl,
            'word_en' => Word::where('id',Cache::get('word_of_the_day_id'))->first()?->word_en,
            'photo_url' => Word::where('id',Cache::get('word_of_the_day_id'))->first()?->photo_url];
        $user_data['latest_streak'] = $request->user()->streak()->orderByDesc('updated_at')->first()?->count ?? 0;
        $user_data['longest_streak'] = $request->user()->streak()->orderByDesc('count')->first()?->count ?? 0;
        $user_data['last_achievement'] =
            ['name' => $request->user()->achievements()->orderByDesc('pivot_created_at')->first()?->name,
            'description' => $request->user()->achievements()->orderByDesc('pivot_created_at')->first()?->description,
            'photo_url' =>$request->user()->achievements()->orderByDesc('pivot_created_at')->first()?->photo_url];
        $user_data['total_collect_heart'] = $request->user()->daily_user_life->total_collect_heart;
        $user_data['next_life_time'] = HeartUpdate::first()->updated_at->timezone('Europe/Warsaw')->modify('+2 hours');
        $user_data['done_tests_amount'] = count($request->user()->tests()->where('status', 1)->get());
        $user_data['all_tests_amount'] = count($request->user()->tests()->get());
        $user_data['last_test'] = [
            'category' => $request->user()->tests()->where('status', 1)->orderByDesc('updated_at')->first()?->category()->first()?->name,
            'difficulty' => $request->user()->tests()->where('status', 1)->orderByDesc('updated_at')->first()?->difficulty,
            'photo_url' => $request->user()->tests()->where('status', 1)->orderByDesc('updated_at')->first()?->category()->first()?->photo_url,
        ];
        return apiResponse(true,$user_data, 'Pomyslnie zwrocono dane',200);
    }

}
