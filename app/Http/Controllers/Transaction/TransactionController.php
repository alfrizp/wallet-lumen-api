<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Transactions\CreateRequest;
use App\Http\Requests\Transactions\UpdateRequest;
use App\Models\Transaction;

class TransactionController extends ApiController
{
    public function __construct()
    {
        $this->middleware('jwt.auth');
        $this->middleware('can:modify-transaction,transaction', ['only' => ['show', 'update', 'destroy']]);
    }

    public function store(CreateRequest $transactionCreateRequest)
    {
        $transactionCreateRequest->save();

        return $this->showMessage(__('transaction.created'), 201);
    }

    public function update(UpdateRequest $transactionUpdateRequest, Transaction $transaction)
    {
        $transaction->update($transactionUpdateRequest->all());

        return $this->showMessage(__('transaction.updated'));
    }

    public function destroy(Transaction $transaction) {
        $transaction->delete();

        return $this->showMessage(__('transaction.deleted'));
    }
}
