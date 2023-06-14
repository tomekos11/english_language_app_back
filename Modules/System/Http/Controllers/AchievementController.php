<?php

namespace Modules\System\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\System\Entities\Achievement;
use Modules\System\Http\Requests\AchievementCreateRequest;
use Modules\System\Http\Requests\AchievementUpdateRequest;
use Modules\System\Services\AchievementService;

class AchievementController extends Controller
{
    /**
     * @param AchievementGetRequest $request
     *
     * Controller wyswietlania achievementow
     *
     * @return JsonResponse
     */

    public function index(Request $request): JsonResponse
    {
        return apiResponse(true, Achievement::all()->toArray(), 'Zwrocono achievementy', 200);
    }

    /**
     * @param AchievementGetRequest $request
     *
     * Controller wyswietlania achievementow
     *
     * @return JsonResponse
     */

    public function show(Request $request, Achievement $achievement)
    {
        return apiResponse(true, $achievement->toArray(), 'Zwrocono achievement', 200);
    }

    public function store(AchievementCreateRequest $request): JsonResponse
    {
        $created = (new AchievementService())->create($request->all());
        if (!$created) {
            return apiResponse(false, [], 'Nie udalo sie stworzyc achievementu', 404);
        } else {
            return apiResponse(true, $created, 'Stoworzono achievement', 204);
        }
    }

    public function update(AchievementUpdateRequest $request, Achievement $achievement)
    {
        $updated = (new AchievementService())->update($achievement, $request->all());

        if (!$updated) {
            return apiResponse(false, [], 'Nie udalo sie zupdatowac achievementu', 404);
        } else {
            return apiResponse(true, $updated, 'Zupdatowano achievement', 200);
        }
    }

    public function delete(Request $request, Achievement $achievement)
    {
        $success = (new AchievementService())->delete($achievement);

        if (!$success) {
            return apiResponse(false, [], 'Nie udalo sie usunac achievementu', 404);
        } else {
            return apiResponse(true, [], 'Usunieto achievement', 200);
        }
    }
}
