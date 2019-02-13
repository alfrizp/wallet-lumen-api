<?php

if (! function_exists('request')) {
    /**
     * Get an instance of the current request or an input item from the request.
     *
     * @param  array|string  $key
     * @param  mixed   $default
     * @return \Illuminate\Http\Request|string|array
     */
    function request($key = null, $default = null)
    {
        if (is_null($key)) {
            return app('request');
        }

        if (is_array($key)) {
            return app('request')->only($key);
        }

        $value = app('request')->__get($key);

        return is_null($value) ? value($default) : $value;
    }
}

if (! function_exists('bcrypt')) {
    /**
     * Hash the given value against the bcrypt algorithm.
     *
     * @param  string  $value
     * @param  array  $options
     * @return string
     */
    function bcrypt($value, $options = [])
    {
        return app('hash')->driver('bcrypt')->make($value, $options);
    }
}

/**
 * Get balance amount based on transactions.
 *
 * @param  string|null  $perDate
 * @param  string|null  $startDate
 * @return float
 */
function balance($perDate = null, $startDate = null)
{
    $transactionQuery = DB::table('transactions');
    if ($perDate) {
        $transactionQuery->where('date', '<=', $perDate);
    }
    if ($startDate) {
        $transactionQuery->where('date', '>=', $startDate);
    }
    $transactions = $transactionQuery->where('user_id', request()->user()->getKey())->get();

    return $transactions->sum(function ($transaction) {
        return $transaction->in_out ? $transaction->amount : -$transaction->amount;
    });
}

function format_number(float $number)
{
    $number = number_format($number, 2);

    return str_replace('-', '- ', $number);
}
