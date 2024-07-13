<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\Models\Bill;

interface CreateBillTransactionServiceInterface
{
    /**
     * Create a transaction for informed bill.
     * 
     * @param Bill $bill
     * @return void
     */
    public function execute(Bill $bill);
}