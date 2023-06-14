<?php

namespace Modules\System\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Auth\Entities\User;

class MoneyLog extends Model
{
    protected $table = 'system__money_logs';
    protected $fillable = [
        'user_id',
        'event',
        'value',
        'old_budget',
        'new_budget',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'value' => 'integer',
        'old_budget' => 'integer',
        'new_budget' => 'integer',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
