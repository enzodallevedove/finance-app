<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Transaction;
use App\Models\PaymentOption;
use App\Interfaces\TransactionRepositoryInterface;
use App\Interfaces\CreateTransferTransactionsServiceInterface;

/**
 * @SuppressWarnings(PHPMD.LongVariable)
 */
class CreateTransferTransactionsService implements CreateTransferTransactionsServiceInterface
{
    /**
     * @param \App\Interfaces\TransactionRepositoryInterface $transactionRepository
     */
    public function __construct(
        private TransactionRepositoryInterface $transactionRepository
    ) {
    }

    /**
     * @inheritDoc
     */
    public function execute(
        PaymentOption $origin,
        PaymentOption $destination,
        float $value,
        string $description,
        string $date
    ): void {
        $originTransaction = new Transaction();
        $originTransaction->name = "Transfer to $destination->name";
        $originTransaction->value = -$value;
        $originTransaction->date = $date;
        $originTransaction->description = $description;
        $originTransaction->paymentoption_id = $origin->id;

        $destinationTransaction = new Transaction();
        $destinationTransaction->name = "Transfer from $origin->name";
        $destinationTransaction->value = $value;
        $destinationTransaction->date = $date;
        $destinationTransaction->description = $description;
        $destinationTransaction->paymentoption_id = $destination->id;

        $this->transactionRepository->save($originTransaction);
        $this->transactionRepository->save($destinationTransaction);
    }
}
