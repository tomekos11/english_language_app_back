<?php

namespace Modules\System\Entities;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HeartUpdate extends Model
{

    protected $table = 'system__heart_update';
    protected $fillable = [
        'id',
        'updated_at',
    ];
    protected $casts = [
        'updated_at' => 'datetime',
    ];
    
    
}
