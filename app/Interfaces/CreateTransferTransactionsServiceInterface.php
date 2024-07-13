<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\Models\PaymentOption;

interface CreateTransferTransactionsServiceInterface
{
    /**
     * Create Transfer Transactions between Payment Options.
     *
     * @param \App\Models\PaymentOption $origin
     * @param \App\Models\PaymentOption $destination
     * @param float $value
     * @param string $description
     * @param string $date
     * @return void
     */
    public function execute(
        PaymentOption $origin,
        PaymentOption $destination,
        float $value,
        string $description,
        string $date
    ): void;
}
