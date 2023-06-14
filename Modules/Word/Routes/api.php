<?php

use Illuminate\Support\Facades\Route;
use Modules\Word\Http\Controllers\WordUserController;
use Modules\Word\Http\Controllers\WordController;
use Modules\Word\Http\Controllers\CategoryController;
use Modules\Word\Http\Controllers\DictionaryController;
use Modules\Word\Http\Controllers\TestController;

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

Route::group(['prefix' => '/word'],function () {
    Route::get('/wordoftheday', [WordController::class, 'showWordOfTheDay'])->middleware('auth:api');
    Route::group(['prefix' => '/dict'], function () {
        Route::get('/', [DictionaryController::class, 'dictionaryIndex'])->middleware('auth:api');
        Route::post('/', [DictionaryController::class, 'dictionaryShow'])->middleware('auth:api');
    });
    Route::group(['prefix' => '/word'], function () {
        Route::get('/{word}', [WordController::class, 'show'])->middleware('auth:api')->name('word.word.show');
        Route::post('/', [WordController::class, 'store'])->middleware('auth:api', 'is_admin')->name('word.word.store');
        Route::patch('/{word}', [WordController::class, 'update'])->middleware('auth:api', 'is_admin')->name('word.word.update');
        Route::delete('/{word}', [WordController::class, 'delete'])->middleware('auth:api', 'is_admin')->name('word.word.delete');
        Route::post('/{word}/addtofavourite',[WordUserController::class, 'addToFavourite'])->middleware('auth:api')->name('word.word.add.to.favourite');
        Route::post('/{word}/revokefromfavourite',[WordUserController::class, 'revokeFromFavourite'])->middleware('auth:api')->name('word.word.revoke.from.favourite');
        Route::post('/{word}/addnote',[WordUserController::class, 'addNote'])->middleware('auth:api')->name('word.word.add.note');
        Route::post('/{word}/addtoreview',[WordUserController::class, 'addToReview'])->middleware('auth:api')->name('word.word.add.to.review');
        Route::post('/{word}/revokefromreview',[WordUserController::class, 'revokeFromReview'])->middleware('auth:api')->name('word.word.revoke.from.review');
    });

    Route::group(['prefix' => '/repetitions'], function(){
        Route::get('/categories_list', [WordUserController::class, 'categories_names_and_rep_amounts'])->middleware('auth:api')->name('word.repetitions.all.categories');
        Route::get('/favourite', [WordUserController::class, 'indexFavourite'])->middleware('auth:api')->name('word.repetitions.favourite');
        Route::get('/review', [WordUserController::class, 'indexReview'])->middleware('auth:api')->name('word.repetitions.index');
        Route::post('/review', [WordUserController::class, 'changeReviewStatus'])->middleware('auth:api')->name('word.repetitions.change.status');
        Route::get('/category', [WordUserController::class, 'indexCategoryReviews'])->middleware('auth:api')->name('word.repetitions.index.category');
        Route::post('/refresh', [WordUserController::class, 'refreshReviewStatus'])->middleware('auth:api')->name('word.repetitions.refresh');
    });

    Route::group(['prefix' => '/category'], function () {
        Route::get('/', [CategoryController::class, 'index'])->middleware('auth:api')->name('word.category.index');
        Route::get('/{category}', [CategoryController::class, 'show'])->middleware('auth:api')->name('word.category.show');
        Route::post('/', [CategoryController::class, 'store'])->middleware('auth:api', 'is_admin')->name('word.category.store');
        Route::patch('/{category}', [CategoryController::class, 'update'])->middleware('auth:api', 'is_admin')->name('word.category.update');
        Route::delete('/{category}', [CategoryController::class, 'delete'])->middleware('auth:api', 'is_admin')->name('word.category.delete');
    });
    //api/word/test to dashboard - zwraca wszystkie testy dla konkretnego usera z ich statusami
    Route::group(['prefix' => '/test'], function () {
        Route::get('/', [TestController::class, 'index'])->middleware('auth:api')->name('word.test.index');
        Route::get('/{nr_testu}', [TestController::class, 'showExercises'])->middleware('auth:api')->name('word.test.show.exercises');
        Route::get('/{nr_testu}/{nr_zadania}', [TestController::class, 'showExercise'])->middleware('auth:api')->name('word.test.show.exercise');
        Route::post('/{nr_testu}/{nr_zadania}', [TestController::class, 'checkAnswer'])->middleware('auth:api')->name('word.test.check.answer');
    });

});
