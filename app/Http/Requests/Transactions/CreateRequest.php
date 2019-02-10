<?php

namespace App\Http\Requests\Transactions;

use App\Models\Transaction;
use Pearl\RequestValidate\RequestAbstract;

class CreateRequest extends RequestAbstract {
    public function rules()
    {
        return [
            'date'        => 'required|date|date_format:Y-m-d',
            'amount'      => 'required|max:60',
            'in_out'      => 'required|boolean',
            'description' => 'required|max:255',
            'category_id' => 'nullable|exists:categories,id,user_id,'.request()->user()->getKey(),
        ];
    }

    public function save()
    {
        $newTransaction = $this->validationData();
        $newTransaction['user_id'] = request()->user()->getKey();

        return Transaction::create($newTransaction);
    }
}
