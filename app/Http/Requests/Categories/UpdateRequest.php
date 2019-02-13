<?php

namespace App\Http\Requests\Categories;

use Pearl\RequestValidate\RequestAbstract;

class UpdateRequest extends RequestAbstract
{
    public function rules()
    {
        return [
            'name' => 'required|max:60',
            'color' => 'required|string|max:7',
            'description' => 'nullable|string|max:255',
        ];
    }
}
