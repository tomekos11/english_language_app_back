<?php

namespace Modules\System\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Auth\Entities\User;

class Streak extends Model
{
    protected $table = 'system__streaks';
    protected $fillable = [
        'user_id',
        'count',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'count' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
