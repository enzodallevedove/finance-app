<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Bill;
use App\Models\Transaction;
use App\Interfaces\BillRepositoryInterface;
use App\Interfaces\TransactionRepositoryInterface;
use App\Interfaces\CreateBillTransactionServiceInterface;

class CreateBillTransactionService implements CreateBillTransactionServiceInterface
{
    public function __construct(
        private TransactionRepositoryInterface $transactionRepository
    ) {
    }

    public function execute(Bill $bill): void
    {
        $transaction = new Transaction();
        $transaction->name = $bill->name;
        $transaction->value = -(abs($bill->value));
        $transaction->description = $bill->description;
        $transaction->date = date("Y-m-d H:i:s");
        $transaction->paymentoption_id = $bill->paymentoption_id;

        $this->transactionRepository->save($transaction);
    }
}