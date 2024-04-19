<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentOption;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\PaymentOptionRepositoryInterface;

class PaymentOptionController extends Controller
{
    public function __construct(
        private PaymentOptionRepositoryInterface $paymentOptionRepository
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paymentOptions = Auth::user()->paymentOptions;
        $paymentOptions->sortByDesc('id');

        return view('paymentoptions', compact('paymentOptions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $paymentOptions = Auth::user()->paymentOptions;
        $paymentOptions->sortByDesc('id');

        return view('paymentoptions.create', compact('paymentOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $paymentOption = new PaymentOption;
        $paymentOption->fill($request->all());
        $paymentOption->user_id = Auth::user()->id;

        $this->paymentOptionRepository->save($paymentOption);

        return $this->index();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $paymentOption = $this->paymentOptionRepository->getById($id);
        $paymentOptions = Auth::user()->paymentOptions;

        return view('paymentoptions.show', compact('paymentOption', 'paymentOptions'));
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
        $paymentOption = $this->paymentOptionRepository->getById($id);
        $paymentOption->fill($request->all());

        $this->paymentOptionRepository->save($paymentOption);

        return $this->index();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->paymentOptionRepository->deleteById($id);

        return $this->index();
    }
}
