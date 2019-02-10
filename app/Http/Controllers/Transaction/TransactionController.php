<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\ApiController;
use App\Models\Transaction;
use App\Http\Requests\Transactions\CreateRequest;

class TransactionController extends ApiController {

    public function __construct() {
        $this->middleware('jwt.auth');
    }

    public function store(CreateRequest $transactionCreateRequest) {
        $transactionCreateRequest->save();

        return $this->showMessage(__('transaction.created'), 201);
    }
}
