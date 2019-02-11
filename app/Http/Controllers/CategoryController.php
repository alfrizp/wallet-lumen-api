<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\Categories\CreateRequest;
use App\Http\Requests\Categories\UpdateRequest;

class CategoryController extends ApiController
{
    public function __construct()
    {
        $this->middleware('jwt.auth');
        $this->middleware('can:modify-category,category', ['only' => ['show', 'update']]);
        $this->middleware('can:delete-category,category', ['only' => ['destroy']]);
    }

    public function index()
    {
        $categories = request()->user->categories;

        return $this->showAll($categories, __('category.categories'));
    }

    public function show(Category $category)
    {
        return $this->showOne($category, __('category.category'));
    }

    public function store(CreateRequest $categoryCreateRequest)
    {
        $categoryCreateRequest->save();

        return $this->showMessage(__('category.created'), 201);
    }

    public function update(UpdateRequest $categoryUpdateRequest, Category $category)
    {
        $category->update($categoryUpdateRequest->all());

        return $this->showMessage(__('category.updated'));
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return $this->showMessage(__('category.deleted'));
    }
}
