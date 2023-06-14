<?php

namespace Modules\Word\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Word\Entities\Test;
use Modules\Word\Enums\TypeEnum;

class Exercise extends Model
{
    use HasFactory;

    protected $table = 'word__exercises';

    protected $fillable = [
        'test_id',
        'external_id',
        'status',
        'type',
        'number',
    ];
  
    // protected $hidden = [
    //     'id',
    //     'user_id',
    //     'category_id',
    // ];

    protected $casts = [
        'test_id' => 'integer',
        'external_id' => 'integer',
        'type' => TypeEnum::class,
        'number' => 'integer',
    ];

    public function test()
    {
        return $this->belongsTo(Test::class, 'test_id', 'id');
    }

    public function external()
    {
        if($this->type == TypeEnum::PAIRS)
        {
            return $this->hasMany(ConnectPairs::class, 'id', 'external_id');
        }
        else if($this->type == TypeEnum::SENTENCES)
        {
            return $this->hasMany(FillSentence::class, 'id', 'external_id');
        }
        else if($this->type == TypeEnum::WORDS)
        {
            return $this->hasMany(Word::class, 'id', 'external_id');
        }
        else if($this->type == TypeEnum::PUZZLE)
        {
            return $this->hasMany(Puzzle::class, 'id', 'external_id');
        }
        //return $this->morphTo();
    }
}
