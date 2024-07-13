<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Interfaces\BillRepositoryInterface;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PaymentOption;

class BillController extends Controller
{
    public function __construct(
        private BillRepositoryInterface $billRepository
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
        $bill = new Bill();
        $bill->fill($request->all());
        $bill->user_id = Auth::user()->id;

        $this->billRepository->save($bill);

        return $this->index();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $bill = $this->billRepository->getById($id);
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
        $bill = $this->billRepository->getById($id);
        $bill->fill($request->all());

        $this->billRepository->save($bill);

        return $this->index();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->billRepository->deleteById($id);

        return $this->index();
    }

    public function markAsPaid(Request $request, string $id)
    {
        $bill = $this->billRepository->getById($id);
        $transaction = new Transaction();
        $transaction->name = $bill->name;
        $transaction->value = -(abs($bill->value));
        $transaction->description = $bill->description;
        $transaction->date = date("Y-m-d H:i:s");
        $transaction->paymentoption_id = $bill->paymentoption_id;
        $transaction->save();

        $paymentOption = PaymentOption::findOrFail($bill->paymentoption_id);
        $paymentOption->balance = $paymentOption->balance + $transaction->value;
        $paymentOption->save();

        return redirect()->route('transactions.index');
    }
}
