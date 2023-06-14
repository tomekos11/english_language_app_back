<?php

namespace Modules\Word\Services;

use Illuminate\Support\Facades\DB;
use Modules\Auth\Entities\User;
use Modules\Word\Entities\Category;
use Modules\Word\Entities\Test;

class TestService
{
    public function index(User $user) : array
    {
        $tests = $user->tests()->get();

        foreach($tests as &$test)
        {
            $category = Category::where(['id' => $test->category_id])->first();
            $test['category'] = $category->name;
        };

        return $tests->toArray();

    }

    public function showExercises(Test $test_id, string $user_id) : array
    {
        return DB::table('word__tests')
            ->toArray();
    }

}
