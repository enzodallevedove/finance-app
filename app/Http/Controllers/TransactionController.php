<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\PaymentOption;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\TransactionRepositoryInterface;
use App\Interfaces\PaymentOptionRepositoryInterface;
use App\Interfaces\UpdatePaymentOptionBalanceServiceInterface;
use Illuminate\Database\Eloquent\Collection;

class TransactionController extends Controller
{
    public function __construct(
        private TransactionRepositoryInterface $transactionRepository,
        private PaymentOptionRepositoryInterface $paymentOptionRepository,
        private UpdatePaymentOptionBalanceServiceInterface $updatePaymentOptionBalanceService
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        /**
         * @var Collection $transactions
         */
        $transactions = Auth::user()->paymentOptions->flatMap->transactions->sortByDesc('date');
        $transactionsByDate = [];

        if ($request->has('payment_options')) {
            $paymentOptionIds = array_values($request->payment_options);
            $transactions = $transactions->whereIn('paymentoption_id', $paymentOptionIds);
        }

        if ($request->has('date')) {
            $transactions = $transactions->where('date', $request->date);
        }

        foreach ($transactions as $transaction) {
            $datetime = $transaction->date;
            $date = substr($datetime, 0, 10);
            $transactionsByDate[$date][] = $transaction;
        }

        $paymentOptions = PaymentOption::all();

        return view(
            'transactions.index',
            compact(
                'transactionsByDate' ,
                'paymentOptions'
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        /**
         * @var \App\Models\User $user
         */
        $user = Auth::user();

        $paymentOptions = $user->paymentOptions;

        $userCategories = $user
            ->categories()
            ->whereNull('parent_id')
            ->with('children')
            ->get();

        $categories = $this->buildCategoriesArray($userCategories);


        return view('transactions.create', compact('paymentOptions', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $transaction = new Transaction();
        $transaction->fill($request->all());

        $categories = $request->categories;

        $this->transactionRepository->save($transaction);

        if ($categories) {
            $transaction->categories()->sync(array_values($categories));
        }

        $this->transactionRepository->save($transaction);

        $paymentOption = $transaction->paymentOption;
        $this->updatePaymentOptionBalanceService->execute($paymentOption, (float) $transaction->value);

        return $this->index();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        /**
         * @var \App\Models\User $user
         */
        $user = Auth::user();

        $transaction = $this->transactionRepository->getById((int) $id);
        $paymentOptions = $user->paymentOptions->sortBy('id');
        $transactionCategoriesIds = $transaction->categories->pluck('id')->toArray();

        $userCategories = $user
            ->categories()
            ->whereNull('parent_id')
            ->with('children')
            ->get();

        $categories = $this->buildCategoriesArray($userCategories);

        return view('transactions.show', compact(
            'transaction',
            'paymentOptions',
            'categories',
            'transactionCategoriesIds'
        ));
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
        $transaction = $this->transactionRepository->getById((int) $id);

        $doPaymentOptionChanged = (int)$transaction->paymentOption->id != (int)$request->paymentoption_id;

        $oldValue = $transaction->value;

        if ($doPaymentOptionChanged) {
            $oldPaymentOption = $transaction->paymentOption;

            $this->updatePaymentOptionBalanceService->execute(
                $oldPaymentOption,
                $oldValue
            );
        }

        $newValue = (float)$request->value;

        $transaction->fill($request->all());

        $categories = $request->categories;

        if ($categories) {
            $transaction->categories()->sync(array_values($categories));
        } else {
            $transaction->categories()->sync([]);
        }


        $this->transactionRepository->save($transaction);

        $this->updatePaymentOptionBalanceService->execute(
            $transaction->paymentOption,
            $oldValue - $newValue
        );

        return $this->index();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $transaction = $this->transactionRepository->getById((int) $id);

        $transactionValue = $transaction->value;
        $paymentOption = $transaction->paymentOption;

        $this->transactionRepository->deleteById((int) $id);

        $this->updatePaymentOptionBalanceService->execute($paymentOption, $transactionValue);

        return $this->index();
    }

    private function buildCategoriesArray(Collection $categories, int $level = 0): array
    {
        $result = [];

        foreach ($categories as $category) {
            $result[] = [
                'id' => $category->id,
                'name' => str_repeat('---', $level) . ($level !== 0 ? ' ' : '') . $category->name
            ];

            if ($category->children->isNotEmpty()) {
                $result = array_merge(
                    $result,
                    $this->buildCategoriesArray($category->children, $level + 1)
                );
            }
        }

        return $result;
    }
}
