<?php

namespace App\Repositories;

use Exception;
use App\Models\Bill;
use Illuminate\Support\Facades\Log;
use App\Interfaces\BillRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BillRepository implements BillRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function getById(int $id): Bill
    {
        try {
            return Bill::findOrFail($id);
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
    public function save(Bill $bill): Bill
    {
        try {
            $result = $bill->save();

            if (!$result) {
                throw new Exception('Could not save bill.');
            }

            return $bill;
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
        $bill = Bill::findOrFail($id);

        try {
            return $bill->delete();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }
}