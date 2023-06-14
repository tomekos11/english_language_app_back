<?php

namespace Modules\Auth\Entities;

use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    protected $table = 'auth__data';
    protected $fillable = [
        'user_id',
        'name',
        'surname',
        'birth_date',
        'photo_url',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'birth_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
