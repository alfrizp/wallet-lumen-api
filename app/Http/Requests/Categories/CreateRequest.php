<?php

namespace App\Http\Requests\Categories;

use App\Models\Category;
use Illuminate\Http\Request;
use Pearl\RequestValidate\RequestAbstract;

class CreateRequest extends RequestAbstract {
    public function rules()
    {
        return [
            'name'        => 'required|max:60',
            'color'       => 'required|string|max:7',
            'description' => 'nullable|string|max:255',
        ];
    }

    public function save()
    {
        $newCategory = $this->validationData();
        $newCategory['user_id'] = request()->user()->id;

        return Category::create($newCategory);
    }
}
