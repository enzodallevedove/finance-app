<?php

namespace App\Interfaces;

use Exception;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface TransactionRepositoryInterface
{
    /**
     * @param int $id
     * @return Transaction
     * 
     * @throws ModelNotFoundException
     */
    public function getById(int $id): Transaction;

    /**
     * @param Transaction $transaction
     * @return Transaction
     * 
     * @throws Exception
     */
    public function save(Transaction $transaction): Transaction;

    /**
     * @param int $id
     * @return bool
     * 
     * @throws ModelNotFoundException
     * @throws Exception
     */
    public function deleteById(int $id): bool;
}