<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Auth\Events\UserLoggedIn;
use Modules\Auth\Events\UserRegistered;
use Modules\Auth\Listeners\CreateDailyUserLife;
use Modules\Auth\Listeners\CreateExercises;
use Modules\Auth\Listeners\CreateTests;
use Modules\Auth\Listeners\CreateUserData;
use Modules\System\Listeners\CollectHearthListener;
use Modules\Word\Events\FavouriteAchievement;
use Modules\Word\Events\ReviewAchievement;
use Modules\Word\Listeners\ReviewAchievementListener;
use Modules\Word\Events\TestDone;
use Modules\Word\Listeners\FavouriteAchievementListener;
use Modules\Word\Listeners\TestDoneListener;
use Modules\System\Events\GetHeart;
class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [

        UserRegistered::class => [
            CreateUserData::class,
            CreateDailyUserLife::class,
            CreateTests::class,
            CreateExercises::class,
        ],
        TestDone::class => [
            TestDoneListener::class,
        ],
        GetHeart::class => [
            CollectHearthListener::class,
        ],
        FavouriteAchievement::class => [
            FavouriteAchievementListener::class,
        ],
        ReviewAchievement::class => [
            ReviewAchievementListener::class,
        ],
        UserLoggedIn::class => [

        ],

        // AchievementCreated::class => [
        // ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
