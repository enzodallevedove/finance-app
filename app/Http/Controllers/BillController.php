<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TransactionController;
use App\Models\PaymentOption;

class BillController extends Controller
{
    public function __construct(
        private TransactionController $transactionController
    ) {
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bills = Auth::user()->bills;
        $bills->sortByDesc('id');

        return view('bills', compact('bills'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $paymentOptions = Auth::user()->paymentOptions;

        return view('bills.create', compact('paymentOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $bill = new Bill;
        $bill->fill($request->all());
        $bill->user_id = Auth::user()->id;
        $bill->save();

        return $this->index();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $bill = Bill::findOrFail($id);
        $paymentOptions = Auth::user()->paymentOptions;

        return view('bills.show', compact('bill', 'paymentOptions'));
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
        $bill = Bill::findOrFail($id);
        $bill->fill($request->all());
        $bill->save();

        return $this->index();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bill = Bill::findOrFail($id);
        $bill->delete();

        return $this->index();
    }

    public function markAsPaid(Request $request, string $id)
    {
        $bill = Bill::findOrFail($id);
        $transaction = new Transaction;
        $transaction->name = $bill->name;
        $transaction->value = -(abs($bill->value));
        $transaction->description = $bill->description;
        $transaction->date = date("Y-m-d H:i:s");
        $transaction->paymentoption_id = $bill->paymentoption_id;
        $transaction->save();

        $paymentOption = PaymentOption::findOrFail($bill->paymentoption_id);
        $paymentOption->balance = $paymentOption->balance + $transaction->value;
        $paymentOption->save();


        return $this->transactionController->index();
    }
}