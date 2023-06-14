<?php

namespace Modules\Word\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Modules\Auth\Entities\User;
use Modules\Word\Entities\Category;
use Modules\Word\Entities\Exercise;

class Test extends Model
{
    protected $table = 'word__tests';
    protected $fillable = [
        'user_id',
        'category_id',
        'status',
        'difficulty',
        'number',
    ];

    protected $hidden = [
        'id',
        'user_id',
        'category_id',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'category_id' => 'integer',
        'number' => 'integer',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id','id');
    }

    public function exercises()
    {
        return $this->hasMany(Exercise::class, 'test_id', 'id');
    }
}
