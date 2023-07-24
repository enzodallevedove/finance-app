<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TransactionController extends Controller
{
    public function index(): JsonResponse
    {
        $transactions = Transaction::all();
        return response()->json($transactions);
    }

    public function store(Request $request): JsonResponse
    {
        $transaction = new Transaction;
        $transaction->fill($request->all());
        $transaction->paymentoption_id = $request->paymentoption_id;
        $transaction->save();

        return response()->json($transaction, 201);
    }

    public function show(int $id): JsonResponse
    {
        try {
            $transaction = Transaction::findOrFail($id);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }

        return response()->json($transaction);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $transaction = Transaction::findOrFail($id);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }

        $transaction->fill($request->all());
        $transaction->save();

        return response()->json($transaction);
    }

    public function destroy(int $id)
    {
        try {
            $transaction = Transaction::findOrFail($id);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }

        $transaction->delete();
    }
}
