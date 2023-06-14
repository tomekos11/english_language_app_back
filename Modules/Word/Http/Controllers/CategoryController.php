<?php

namespace Modules\Word\Http\Controllers;

use Modules\Word\Entities\Category;
use Illuminate\Routing\Controller;
use Modules\Word\Services\CategoryService;
use Modules\Word\Http\Requests\CategoryCrUpdRequest;
use Illuminate\Http\Request;
class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categoryAll = (new CategoryService())->index($request->user()->id);
        return apiResponse(True, $categoryAll, 'Udalo sie wyswietlic wszystkie kategorie', 200);
    }
    public function store(CategoryCrUpdRequest $request)
    {
        $stored = (new CategoryService())->create($request->all());
        if(!$stored)
            return apiResponse(False, $stored, 'Nie udalo sie dodac nowej kategorii', 200);
        else
            return apiResponse(True, $stored, 'Udalo sie dodac nowa kategorie', 200);
    }
    public function update(Request $request, Category $category)
    {
        $success = (new CategoryService())->update($request->all(), $category);
        return apiResponse($success, [], !$success ? 'Nie Udalo sie zaktualizowac kategoriI' : 'Udalo sie zaktualizowac kategorie', $success ? 400 : 200);
    }
    public function show(Category $category)
    {
        return apiResponse(True, $category->toArray(), 'Udalo sie wyswietlic kategorie', 200);
    }
    public function delete(Request $request, Category $category)
    {
        $success = (new CategoryService())->delete($category);
        return apiResponse($success, [], !$success ? 'Nie udalo sie usunac kategorii' : 'Udalo sie usunac kategorie', !$success ? 400 : 200);
    }


}
