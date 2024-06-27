<?php

namespace App\Repositories;

use Exception;
use App\Models\PaymentOption;
use Illuminate\Support\Facades\Log;
use App\Interfaces\PaymentOptionRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PaymentOptionRepository implements PaymentOptionRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function getById(int $id): PaymentOption
    {
        try {
            return PaymentOption::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw $e;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }

    /**
     * @inheritDoc
     */
    public function save(PaymentOption $paymentOption): PaymentOption
    {
        try {
            $result = $paymentOption->save();

            if (!$result) {
                throw new Exception('Could not save Payment Option.');
            }

            return $paymentOption;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }

    /**
     * @inheritDoc
     */
    public function deleteById(int $id): bool
    {
        $paymentOption = PaymentOption::findOrFail($id);

        try {
            return $paymentOption->delete();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }
}
