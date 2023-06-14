<?php

namespace Modules\System\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Auth\Entities\User;
use Modules\System\Enums\EventTypeEnum;

class Achievement extends Model
{
    protected $table = 'system__achievements';
    protected $fillable = [
        'name',
        'event_type',
        'value',
        'money',
        'description',
        'photo_url'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    protected $casts = [
        'event_type' => EventTypeEnum::class,
        'value' => 'integer',
        'money' => 'integer',
    ];

    public function user()
    {
        return $this->belongsToMany(User::class, 'system__users_achievements', 'achievement_id', 'user_id', 'id', 'id');
    }
}
