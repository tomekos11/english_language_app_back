<?php

namespace Modules\Word\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Auth\Entities\User;
use Modules\Word\Entities\ConnectPairs;
use Modules\Word\Entities\Exercise;
use Modules\Word\Enums\DifficultyEnum;

class Word extends Model
{
    protected $table = 'word__words';

    protected $fillable = [
        'category_id',
        'word_en',
        'word_pl',
        'difficulty',
        'photo_url',
    ];

    protected $hidden = [
        'category_id',
    ];

    protected $casts = [
        'id' => 'integer',
        'category_id' => 'integer',
        'difficulty' => DifficultyEnum::class,
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }


    public function users()
    {
        return $this->belongsToMany(User::class, 'word__words_users', 'word_id', 'user_id', 'id', 'id')->withPivot(['is_favourite', 'review','notes','created_at','updated_at']);
    }

    public function ConnectPairs()
    {
        $this->belongsToMany(ConnectPairs::class, 'word__pairs_words_pivot', 'word_id', 'pair_id', 'id', 'id')->withPivot(['is_favourite','notes','created_at','updated_at']);
    }

    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }
}
