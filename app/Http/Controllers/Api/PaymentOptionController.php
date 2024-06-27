<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PaymentOption;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PaymentOptionController extends Controller
{
    public function index(): JsonResponse
    {
        $paymentOptions = PaymentOption::all();
        return response()->json($paymentOptions);
    }

    public function store(Request $request): JsonResponse
    {
        $paymentOption = new PaymentOption();
        $paymentOption->fill($request->all());
        $paymentOption->user_id = $request->user_id;
        $paymentOption->save();

        return response()->json($paymentOption, 201);
    }

    public function show(int $id): JsonResponse
    {
        try {
            $paymentOption = PaymentOption::findOrFail($id);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }

        return response()->json($paymentOption);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $paymentOption = PaymentOption::findOrFail($id);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }

        $paymentOption->fill($request->all());
        $paymentOption->save();

        return response()->json($paymentOption);
    }

    public function destroy(int $id)
    {
        try {
            $paymentOption = PaymentOption::findOrFail($id);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }

        $paymentOption->delete();
    }
}
