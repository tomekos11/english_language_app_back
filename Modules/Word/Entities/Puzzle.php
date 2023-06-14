<?php

namespace Modules\Word\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Word\Entities\Exercise;

class Puzzle extends Model
{
    use HasFactory;

    protected $table = 'word__puzzle';
    protected $fillable = [
        'correct_answer',
        'sentence',
        'language',
    ];

    protected $casts = [
        'sentence' => 'array',
        'correct_answer' => 'array',
    ];
    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }
}
