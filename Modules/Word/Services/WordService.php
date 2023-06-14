<?php 

namespace Modules\Word\Services;

use Modules\Word\Entities\Word;

class WordService
{
    public function create(array $dane) : array
    {
        return Word::create($dane)->toArray();
    }

    public function update(array $request_data, Word $word) : bool
    {
        return $word->update($request_data);
    }

    public function delete(Word $word) : bool
    {
        return $word->delete();
    }
}