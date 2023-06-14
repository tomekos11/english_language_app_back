<?php

namespace Modules\System\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\System\Enums\GameTypeEnum;
use Modules\Word\Entities\Exercise;
use Modules\Word\Enums\TypeEnum;
use Modules\System\Entities\Streak;
class StatisticsController extends Controller
{
    public function index_user_statistics(Request $request)
    {
        $exercise_good = $request->user()->tests()
            ->with('exercises')
            ->whereHas('exercises', function ($query) {
                $query->where('status', 1);
            })
            ->withCount(['exercises' => function ($query) {
                $query->where('status', 1);
            }])
            ->get();
        $exerciseCount = 0;
        $exercisePair = 0;
        $exerciseSent = 0;
        $exercisePuzz = 0;
        foreach ($exercise_good as $result) {
            $exerciseCount += $result->exercises_count;
            $exercisePair += $result->exercises()
                ->where('status', 1)
                ->where('type', 'connect_pair')
                ->count();
            $exerciseSent += $result->exercises()
                ->where('status', 1)
                ->where('type', 'fill_sentence')
                ->count();
            $exercisePuzz += $result->exercises()
                ->where('status', 1)
                ->where('type', 'puzzle')
                ->count();
        }
        $statistics = [];
        $statistics['achievements_count'] = [
            'name' =>  'Liczba zdobytych osiągnięć',
            'value' => $request->user()->achievements()->get()->count(),
        ];
        $statistics['achievements_last'] = [
            'name' =>  'Ostatnio zdobyte osiągnięcie',
            'value' => $request->user()->achievements()->orderByDesc('updated_at')->first()->name ?? null,
        ];
        $statistics['tests_count'] = [
            'name' =>  'Liczba wykonanych testów',
            'value' => $request->user()->tests()->where('status', 1)->get()->count(),
        ];
        $statistics['exercises_count'] = [
            'name' =>  'Liczba wykonanych zadań',
            'value' => $exerciseCount,
        ];
        $statistics['exercises_count_connect_pair'] = [
            'name' =>  'Liczba wykonanych zadań typu połącz pary',
            'value' => $exercisePair,
        ];
        $statistics['exercises_count_fill_sentence'] = [
            'name' =>  'Liczba wykonanych zadań typu uzupełnij lukę',
            'value' => $exerciseSent,
        ];
        $statistics['exercises_count_puzzle'] = [
            'name' =>  'Liczba wykonanych zadań typu rozsypanka',
            'value' => $exercisePuzz,
        ];
        $statistics['count_streak'] = [
            'name' =>  'Liczba streaków',
            'value' => Streak::orderByRaw('count DESC')->where('user_id', $request->user()->id)->get()->count(),
        ];
        $statistics['best_streak'] = [
            'name' =>  'Najdłuższy streak',
            'value' => Streak::orderByRaw('count DESC')->where('user_id', $request->user()->id)->first()?->count,
        ];
        $statistics['worst_streak'] = [
            'name' =>  'Najkrótszy streak',
            'value' => Streak::orderByRaw('count ASC')->where('user_id', $request->user()->id)->first()?->count,
        ];
        $statistics['avg_streak'] = [
            'name' =>  'Średni czas trwania streaka',
            'value' => Streak::get()->where('user_id', $request->user()->id)->avg('count'),
        ];
        $statistics['count_heart'] = [
            'name' =>  'Liczba zebranych serc',
            'value' => $request->user()->daily_user_life()->first()?->total_collect_heart,
        ];
        $statistics['count_favourite'] = [
            'name' =>  'Liczba ulubionych słówek',
            'value' => $request->user()->words()->where('is_favourite', 1)->count(),
        ];
        $statistics['count_review'] = [
            'name' =>  'Liczba słówek dodanych do powtórek',
            'value' => $request->user()->words()->where('review', 1)->count(),
        ];
        $statistics['count_review_done'] = [
            'name' =>  'Liczba wykonanych słówek z powtórek',
            'value' => $request->user()->words()->where('review_done', 1)->count(),
        ];
        $statistics['best_15s_result'] = [
            'name' =>  'Najlepszy wynik z wyzwania 15s',
            'value' => $request->user()->time_games()->where('type', GameTypeEnum::QUARTER_MINUTE)->where('user_id', $request->user()->id)->orderByDesc('result')->first()->result ?? null,
        ];
        $statistics['best_30s_result'] = [
            'name' =>  'Najlepszy wynik z wyzwania 30s',
            'value' => $request->user()->time_games()->where('type', GameTypeEnum::HALF_MINUTE)->where('user_id', $request->user()->id)->orderByDesc('result')->first()->result ?? null,
        ];
        $statistics['best_60s_result'] = [
            'name' =>  'Najlepszy wynik z wyzwania 60s',
            'value' => $request->user()->time_games()->where('type', GameTypeEnum::ONE_MINUTE)->where('user_id', $request->user()->id)->orderByDesc('result')->first()->result ?? null,
        ];
        $statistics['avg_15s_result'] = [
            'name' =>  'Średni wynik z wyzwania 15s',
            'value' => $request->user()->time_games()->where('type', GameTypeEnum::QUARTER_MINUTE)->where('user_id', $request->user()->id)->get()->avg('result'),
        ];
        $statistics['avg_30s_result'] = [
            'name' =>  'Średni wynik z wyzwania 30s',
            'value' => $request->user()->time_games()->where('type', GameTypeEnum::HALF_MINUTE)->where('user_id', $request->user()->id)->get()->avg('result'),
        ];
        $statistics['avg_60s_result'] = [
            'name' =>  'Średni wynik z wyzwania 60s',
            'value' => $request->user()->time_games()->where('type', GameTypeEnum::ONE_MINUTE)->where('user_id', $request->user()->id)->get()->avg('result'),
        ];
        return apiResponse(true, $statistics, 'Zwrocono statystyki uzytkownika', 200);
    }
}
