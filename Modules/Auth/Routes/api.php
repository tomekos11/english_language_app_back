<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\AuthController;
use Modules\Auth\Http\Controllers\DataController;
use Modules\Auth\Http\Controllers\RankingController;
use Modules\Auth\Http\Controllers\UserController;

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

Route::group(['prefix' => '/auth'], function () {
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
    Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('auth.logout');

    Route::group(['prefix' => '/user', 'middleware' => 'auth:api'], function () {
        Route::group(['prefix' => '/data'], function () {
            Route::get('/dashboard', [DataController::class, 'dashboardData'])->middleware('auth:api')->name('auth.user.data.dashboard');
            Route::get('/me', [DataController::class, 'me'])->middleware('auth:api')->name('auth.user.data.me');
            Route::patch('/change_data',[DataController::class, 'changeData'])->middleware('auth:api')->name('auth.user.data.change.data');
            Route::post('/change_avatar', [DataController::class, 'changeAvatar'])->middleware('auth:api')->name('auth.user.change.avatar');
        });
        Route::group(['prefix' => '/role'], function(){
            Route::get('/me', [UserController::class, 'me'])->middleware('auth:api', 'is_admin')->name('auth.user.role.me');
            Route::get('/{user}',[UserController::class, 'show'])->middleware('auth:api', 'is_admin')->name('auth.user.role.show');
            Route::post('/{user}',[UserController::class, 'set'])->middleware('auth:api', 'is_admin')->name('auth.user.role.set');
        });
    });

    Route::group(['prefix' => '/ranking', 'middleware' => 'auth:api'], function () {
        Route::get('/money', [RankingController::class, 'rankingByMoney'])->middleware('auth:api')->name('auth.ranking.by.money');
        Route::get('/lvl', [RankingController::class, 'rankingByLvl'])->middleware('auth:api')->name('auth.ranking.by.lvl');
        Route::get('/15s', [RankingController::class, 'rakingBy15s'])->middleware('auth:api')->name('auth.ranking.by.15s');
        Route::get('/30s', [RankingController::class, 'rakingBy30s'])->middleware('auth:api')->name('auth.ranking.by.30s');
        Route::get('/60s', [RankingController::class, 'rakingBy60s'])->middleware('auth:api')->name('auth.ranking.by.60s');
        Route::get('/all', [RankingController::class, 'rakingAll'])->middleware('auth:api')->name('auth.ranking.by.all');
    });
});
