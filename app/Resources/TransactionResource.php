<?php

namespace App\Resources;

class TransactionResource extends ApiResource
{
    protected $message;
    protected $code;

    public function __construct($resource, $message = '', $code = 200)
    {
        parent::__construct($resource);

        $this->message = $message;
        $this->code = $code;
    }

    public function toArray($request)
    {
        $transaction = $this->resource;

        return [
            'id' => (int) $transaction->id,
            'date' => $transaction->date,
            'amount' => (float) $transaction->amount,
            'amount_string' => $transaction->amount_string,
            'description' => $transaction->description,
            'in_out' => (bool) $transaction->in_out,
            'type' => $transaction->type,
            'created_at' => (int) $transaction->created_at->timestamp,
            'updated_at' => (int) $transaction->updated_at->timestamp,
            'category' => new CategoryResource($transaction->category),
        ];
    }
}
