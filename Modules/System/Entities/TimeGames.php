<?php

namespace Modules\System\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\System\Enums\GameTypeEnum;
use Modules\Auth\Entities\User;
class TimeGames extends Model
{

    protected $table = 'system__time_games_results';

    protected $fillable = [
        'id',
        'user_id',
        'type',
        'result',
        'end_time',
    ];

    protected $hidden = [

    ];

    protected $casts = [
        'end_time' => 'datetime',
        'result' => 'integer',
        'type' => GameTypeEnum::class,
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
