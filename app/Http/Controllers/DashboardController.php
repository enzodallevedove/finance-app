<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\CategoryRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __construct(
        private readonly CategoryRepositoryInterface $categoryRepository,
    ) {
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $paymentOptions = Auth::user()->paymentOptions->where('balance', '!=', '0')->sortByDesc('balance');
        $expensesPerCategoryThisMonth = $this->expensesPerCategoryThisMonth();

        return view('dashboard', compact(
            'paymentOptions',
            'expensesPerCategoryThisMonth'
        ));
    }

    private function expensesPerCategoryThisMonth(): array
    {
        $currentMonth = Carbon::now()->month-1;
        $currentYear = Carbon::now()->year;

        $filterByParentIdNull = true;

        $categoryTotals = DB::table('categories')
            ->join('category_transaction', 'categories.id', '=', 'category_transaction.category_id')
            ->join('transactions', 'category_transaction.transaction_id', '=', 'transactions.id')
            ->whereMonth('transactions.date', $currentMonth)
            ->whereYear('transactions.date', $currentYear)
            ->when($filterByParentIdNull, function ($query) {
                return $query->whereNull('categories.parent_id');
            })
            ->groupBy('categories.id', 'categories.name')
            ->select('categories.name', DB::raw('SUM(transactions.value) as total_value'))
            ->orderBy('total_value', 'desc')
            ->get();

        return $categoryTotals->toArray();
    }
}
