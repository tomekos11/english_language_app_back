<?php

use Illuminate\Support\Facades\Route;
use Modules\System\Http\Controllers\AchievementController;
use Modules\System\Http\Controllers\DailyUserLifeController;
use Modules\System\Http\Controllers\StreakController;
use Modules\System\Http\Controllers\TimeGamesController;
use Modules\System\Http\Controllers\UserAchievementController;
use Modules\System\Http\Controllers\StatisticsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//ponizej api/system/achievement
Route::group(['prefix' => '/system'], function () {
    Route::get('/statistics', [StatisticsController::class, 'index_user_statistics'])->middleware('auth:api')->name('system.statistics');
    Route::group(['prefix' => '/achievement'], function () {
        Route::get('/me', [UserAchievementController::class, 'index_users_achievements'])->middleware('auth:api')->name('system.achievement.me');
        Route::get('/', [AchievementController::class, 'index'])->middleware('auth:api');
        Route::get('/{achievement}', [AchievementController::class, 'show'])->middleware('auth:api');
        Route::post('/', [AchievementController::class, 'store'])->middleware('auth:api', 'is_admin')->name('system.achievement.store');
        Route::patch('/{achievement}', [AchievementController::class, 'update'])->middleware('auth:api', 'is_admin')->name('system.achievement.update');
        Route::delete('/{achievement}', [AchievementController::class, 'delete'])->middleware('auth:api', 'is_admin')->name('system.achievement.delete');
    });

    Route::group(['prefix' => '/daily_user_life'], function () {
        Route::get('/', [DailyUserLifeController::class, 'show'])->middleware('auth:api')->name('system.daily.user.life.show');
        Route::patch('/minus', [DailyUserLifeController::class, 'minusLife'])->middleware('auth:api')->name('system.daily.user.life.minusLife');
        Route::patch('/plus', [DailyUserLifeController::class, 'plusLife'])->middleware('auth:api')->name('system.daily.user.life.plusLife');
    });

    Route::group(['prefix' => '/streak'], function () {
        Route::get('/', [StreakController::class, 'showAllStreaks'])->middleware('auth:api')->name('system.streak.show.all.streaks');
        Route::get('/latest', [StreakController::class, 'showLatestStreakInfo'])->middleware('auth:api')->name('system.streak.show.latest.streak');
        Route::get('/longest', [StreakController::class, 'showLongestStreakInfo'])->middleware('auth:api')->name('system.streak.show.longest.streak');
    });

    Route::group(['prefix' => '/games'], function () {
        Route::post('/', [TimeGamesController::class, 'downloadWords'])->middleware('auth:api')->name('system.games.download.words');
        Route::post('/send', [TimeGamesController::class, 'sendWord'])->middleware('auth:api')->name('system.games.send.word');
        Route::post('/history', [TimeGamesController::class, 'history'])->middleware('auth:api')->name('system.games.history');
    });

});


