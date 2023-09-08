<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillController extends Controller
{
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
}