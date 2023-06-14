<?php

namespace Modules\System\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Auth\Entities\User;

class DailyUserLife extends Model
{
    protected $table = 'system__daily_user_lives';
    protected $fillable = [
        'user_id',
        'life_count',
        'total_collect_heart',
        'next_heart_unix_time',
    ];
    protected $casts = [
        'user_id' => 'integer',
        'life_count' => 'integer',
        'total_collect_heart' => 'integer',
        'next_heart_unix_time' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
