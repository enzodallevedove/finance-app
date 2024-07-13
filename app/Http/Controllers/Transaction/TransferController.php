<?php

declare(strict_types=1);

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Interfaces\TransactionRepositoryInterface;
use App\Interfaces\PaymentOptionRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

/**
 * @SuppressWarnings(PHPMD.LongVariable)
 */
class TransferController extends Controller
{
    public function __construct(
        private TransactionRepositoryInterface $transactionRepository,
        private PaymentOptionRepositoryInterface $paymentOptionRepository
    ) {
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $paymentOptions = Auth::user()->paymentOptions;

        return view('transactions.transfer.create', compact('paymentOptions'));
    }

    /**
     * @param Request $request
     * @return mixed|RedirectResponse
     */
    public function store(Request $request)
    {
        $originPaymentOptionId = $request->paymentoption_origin_id;
        $destinationPaymentOptionId = $request->paymentoption_destination_id;
        $value = abs((float) $request->value);
        $description = $request->description;
        $date = $request->date;

        $originPaymentOption = $this->paymentOptionRepository->getById((int) $originPaymentOptionId);
        $destinationPaymentOption = $this->paymentOptionRepository->getById((int) $destinationPaymentOptionId);

        $originTransaction = new Transaction();
        $originTransaction->name = "Transfer to $destinationPaymentOption->name";
        $originTransaction->value = -$value;
        $originTransaction->date = $date;
        $originTransaction->description = $description;
        $originTransaction->paymentoption_id = $originPaymentOption->id;

        $destinationTransaction = new Transaction();
        $destinationTransaction->name = "Transfer from $originPaymentOption->name";
        $destinationTransaction->value = $value;
        $destinationTransaction->date = $date;
        $destinationTransaction->description = $description;
        $destinationTransaction->paymentoption_id = $destinationPaymentOption->id;

        $this->transactionRepository->save($originTransaction);
        $originPaymentOption->balance = $originPaymentOption->balance - $value;
        $this->paymentOptionRepository->save($originPaymentOption);

        $this->transactionRepository->save($destinationTransaction);
        $destinationPaymentOption->balance = $destinationPaymentOption->balance + $value;
        $this->paymentOptionRepository->save($destinationPaymentOption);

        return redirect()->route('transactions.index');
    }
}
