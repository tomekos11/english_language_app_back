<?php

namespace Modules\Word\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Word\Entities\Word;
use Modules\Word\Entities\Exercise;

class ConnectPairs extends Model
{
    use HasFactory;

    protected $table = 'word__connect_pairs';
    protected $fillable = [
        
    ];
    
    public function words()
    {
        return $this->belongsToMany(Word::class, 'word__pairs_words_pivot', 'pair_id', 'word_id', 'id', 'id');
    }
    
    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }
}
