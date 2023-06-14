<?php

namespace Modules\Word\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Word\Entities\Exercise;

class FillSentence extends Model
{
    use HasFactory;

    protected $table = 'word__fill_sentences';
    protected $fillable = [
        'sentence',
        'correct_answer',
    ];

    protected $hidden = [
        'id',
    ];

    protected $casts = [
        'sentence' => 'array',
    ];

    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }
}
