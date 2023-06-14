<?php

namespace Modules\Word\Entities;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'word__categories';
    protected $fillable = [
        'name',
        'photo_url',
    ];

    public function words()
    {
        return $this->hasMany(Word::class);
    }

    public function tests()
    {
        return $this->hasMany(Test::class, 'category_id', 'id');
    }
}
