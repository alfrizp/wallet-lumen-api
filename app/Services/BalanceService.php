<?php

namespace App\Services;

use Carbon\Carbon;

class BalanceService
{
    public static function getStartBalance($transactions) {
        $startBalance = 0;
        if ($transactions->last()) {
            $startBalance = balance(
                Carbon::parse($transactions->last()->date)
                    ->subDay()->format('Y-m-d')
            );
        }

        return $startBalance;
    }

    public static function getEndBalance($transactions) {
        $endBalance = 0;
        if ($transactions->first()) {
            $endBalance = balance($transactions->first()->date);
        }

        return $endBalance;
    }
}
