<?php

namespace App\Interfaces;

use Exception;
use App\Models\Bill;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface BillRepositoryInterface
{
    /**
     * @param int $id
     * @return Bill
     * 
     * @throws ModelNotFoundException
     */
    public function getById(int $id): Bill;

    /**
     * @param Bill $bill
     * @return Bill
     * 
     * @throws Exception
     */
    public function save(Bill $bill): Bill;

    /**
     * @param int $id
     * @return bool
     * 
     * @throws ModelNotFoundException
     * @throws Exception
     */
    public function deleteById(int $id): bool;
}