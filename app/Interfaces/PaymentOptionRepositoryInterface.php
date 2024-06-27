<?php

namespace App\Interfaces;

use Exception;
use App\Models\PaymentOption;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface PaymentOptionRepositoryInterface
{
    /**
     * @param int $id
     * @return PaymentOption
     *
     * @throws ModelNotFoundException
     */
    public function getById(int $id): PaymentOption;

    /**
     * @param PaymentOption $paymentOption
     * @return PaymentOption
     *
     * @throws Exception
     */
    public function save(PaymentOption $paymentOption): PaymentOption;

    /**
     * @param int $id
     * @return bool
     *
     * @throws ModelNotFoundException
     * @throws Exception
     */
    public function deleteById(int $id): bool;
}
