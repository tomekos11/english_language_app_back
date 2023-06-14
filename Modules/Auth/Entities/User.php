<?php

namespace Modules\Auth\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Laravel\Passport\HasApiTokens;
use Modules\Auth\Enums\RoleEnum;
use Modules\Word\Entities\Test;
use Modules\Word\Entities\Word;
use Modules\System\Entities\Achievement;
use Modules\System\Entities\DailyUserLife;
use Modules\System\Entities\MoneyLog;
use Modules\System\Entities\Streak;
use Modules\System\Entities\TimeGames;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = 'auth__users';

    protected $fillable = [
        'email',
        'password',
        'money',
        'role',
        'favourite_counter',
        'review_counter',
        'xp',
        'lvl',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'id',
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'money' => 'integer',
        'favourite_counter' => 'integer',
        'review_counter' => 'integer',
        'lvl' => 'integer',
        'xp' => 'integer',
        'role' => RoleEnum::class,
    ];

    public function words()
    {
        return $this->belongsToMany(Word::class, 'word__words_users', 'user_id', 'word_id', 'id', 'id')
        ->withPivot(['is_favourite', 'review','notes','created_at','updated_at']);
    }

    public function tests()
    {
        return $this->hasMany(Test::class, 'user_id', 'id');
    }

    public function money_logs()
    {
        return $this->hasMany(MoneyLog::class, 'user_id', 'id');
    }

    public function achievements()
    {
        return $this->belongsToMany(Achievement::class, 'system__users_achievements', 'user_id', 'achievement_id', 'id', 'id', )->withPivot(['created_at', 'updated_at']);
    }

    public function data()
    {
        return $this->hasOne(Data::class, 'user_id', 'id');
    }

    public function daily_user_life()
    {
        return $this->hasOne(DailyUserLife::class, 'user_id', 'id');
    }

    public function streak()
    {
        return $this->hasMany(Streak::class, 'user_id', 'id');
    }

    public function time_games()
    {
        return $this->hasMany(TimeGames::class, 'user_id', 'id');
    }

}
