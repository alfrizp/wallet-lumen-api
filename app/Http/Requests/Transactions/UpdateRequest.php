<?php

namespace App\Http\Requests\Transactions;

use Pearl\RequestValidate\RequestAbstract;

class UpdateRequest extends RequestAbstract
{
    public function rules()
    {
        return [
            'date' => 'required|date|date_format:Y-m-d',
            'amount' => 'required|max:60',
            'in_out' => 'required|boolean',
            'description' => 'required|max:255',
            'category_id' => 'nullable|exists:categories,id,user_id,'.request()->user()->getKey(),
        ];
    }
}
