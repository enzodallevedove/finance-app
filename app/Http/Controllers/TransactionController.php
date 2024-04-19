<?php

namespace App\Http\Controllers;

use App\Models\PaymentOption;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\TransactionRepositoryInterface;
use App\Interfaces\PaymentOptionRepositoryInterface;

class TransactionController extends Controller
{
    public function __construct(
        private TransactionRepositoryInterface $transactionRepository,
        private PaymentOptionRepositoryInterface $paymentOptionRepository
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Auth::user()->paymentOptions->flatMap->transactions;

        return view('transactions', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $paymentOptions = Auth::user()->paymentOptions;

        return view('transactions.create', compact('paymentOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $transaction = new Transaction;
        $transaction->fill($request->all());

        $this->transactionRepository->save($transaction);

        $paymentOption = $transaction->paymentOption;
        $paymentOption->balance = $paymentOption->balance + $transaction->value;

        $this->paymentOptionRepository->save($paymentOption);

        return $this->index();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $transaction = $this->transactionRepository->getById($id);
        $paymentOptions = Auth::user()->paymentOptions;

        return view('transactions.show', compact('transaction', 'paymentOptions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return $this->show($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $transaction = $this->transactionRepository->getById($id);
        $transaction->fill($request->all());

        $this->transactionRepository->save($transaction);

        return $this->index();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->transactionRepository->deleteById($id);

        return $this->index();
    }
}