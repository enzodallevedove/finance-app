<?php

declare(strict_types=1);

namespace App\Interfaces;

use Exception;
use App\Models\PaymentOption;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface UpdatePaymentOptionBalanceServiceInterface
{
    /**
     * Updates Payment Option balance with the value informed.
     *
     * @param PaymentOption $paymentOption
     * @param float $value
     * @return void
     *
     * @throws ModelNotFoundException
     * @throws Exception
     */
    public function execute(PaymentOption $paymentOption, float $value): void;
}
