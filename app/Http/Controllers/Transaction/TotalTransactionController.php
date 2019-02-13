<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\ApiController;
use App\Services\BalanceService;
use App\Services\TransactionService;

class TotalTransactionController extends ApiController
{
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    public function index()
    {
        $yearMonth = $this->getYearMonth();
        $transactions = $this->getTransactions($yearMonth);

        $startBalance = BalanceService::getStartBalance($transactions);
        $endBalance = BalanceService::getEndBalance($transactions);
        $totalIncome = TransactionService::getTotalIncome($transactions);
        $totalSpending = TransactionService::getTotalSpending($transactions);

        return $this->successDataResponse([
            'start_balance' => format_number($startBalance),
            'end_balance' => format_number($endBalance),
            'total_income' => format_number($totalIncome),
            'total_spending' => format_number($totalSpending),
            'difference' => format_number($totalIncome - $totalSpending),
        ], __('transaction.total'), 200);
    }
}
