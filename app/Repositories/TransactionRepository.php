<?php

namespace App\Repositories;

use Exception;
use App\Models\Transaction;
use Illuminate\Support\Facades\Log;
use App\Interfaces\TransactionRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TransactionRepository implements TransactionRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function getById(int $id): Transaction
    {
        try {
            return Transaction::findOrFail($id);
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
    public function save(Transaction $transaction): Transaction
    {
        try {
            $result = $transaction->save();

            if (!$result) {
                throw new Exception('Could not save transaction.');
            }

            return $transaction;
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
        $transaction = Transaction::findOrFail($id);

        try {
            return $transaction->delete();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }
}