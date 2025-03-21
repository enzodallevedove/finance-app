<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\PaymentOption;
use App\Repositories\PaymentOptionRepository;
use App\Interfaces\UpdatePaymentOptionBalanceServiceInterface;

/**
 * @SuppressWarnings(PHPMD.LongVariable)
 */
class UpdatePaymentOptionBalanceService implements UpdatePaymentOptionBalanceServiceInterface
{
    /**
     * @param PaymentOptionRepository $paymentOptionRepository
     */
    public function __construct(
        private PaymentOptionRepository $paymentOptionRepository
    ) {
    }

    /**
     * @inheritDoc
     */
    public function execute(PaymentOption $paymentOption, float $value): void
    {
        if ($value === 0.0) {
            return;
        }

        $currentBalance = $paymentOption->balance;

        $newBalance = $value > 0
            ? $currentBalance + $value
            : $currentBalance - abs($value);

        $paymentOption->balance = $newBalance;

        $this->paymentOptionRepository->save($paymentOption);
    }
}
