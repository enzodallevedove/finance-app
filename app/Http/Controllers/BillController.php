<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Interfaces\BillRepositoryInterface;
use App\Interfaces\CreateBillTransactionServiceInterface;
use App\Interfaces\UpdatePaymentOptionBalanceServiceInterface;
use App\Interfaces\PaymentOptionRepositoryInterface;

/**
 * @SuppressWarnings(PHPMD.LongVariable)
 */
class BillController extends Controller
{
    public function __construct(
        private BillRepositoryInterface $billRepository,
        private CreateBillTransactionServiceInterface $createBillTransactionService,
        private UpdatePaymentOptionBalanceServiceInterface $updatePaymentOptionBalanceService,
        private PaymentOptionRepositoryInterface $paymentOptionRepository
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

    /**
     * Summary of markAsPaid
     *
     * @param Request $request
     * @param string $id
     * @return mixed|RedirectResponse
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function markAsPaid(Request $request, string $id)
    {
        $bill = $this->billRepository->getById($id);
        $paymentOption = $this->paymentOptionRepository->getById($bill->paymentoption_id);

        $value = $bill->value;

        $this->createBillTransactionService->execute($bill);
        $this->updatePaymentOptionBalanceService->execute($paymentOption, $value);

        return redirect()->route('transactions.index');
    }
}
