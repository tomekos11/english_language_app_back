<?php

namespace Modules\Word\Services;

use Modules\Word\Entities\Category;
use Illuminate\Support\Facades\DB;
class CategoryService
{
    public function index($user_id = null) : array
    {
        if(!is_null($user_id)) {
            $category = Category::with(['tests' => function($query) use ($user_id) {
                $query->where('user_id', $user_id)->select('*');
            }]);
        } else {
            $category = Category::with(['tests']);
        }
        return $category->get()->toArray();
    }

    public function create(array $category) : array
    {
        return Category::create($category)->toArray();
    }
    public function update(array $request_data, Category $category) : bool
    {
        return $category->update($request_data);
    }
    public function delete(Category $category) : bool
    {
        return $category->delete();
    }
}
