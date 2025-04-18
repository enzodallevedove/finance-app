<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Transaction;
use App\Models\Category;

class DashboardController extends Controller
{
    public function __construct(
        private readonly CategoryRepositoryInterface $categoryRepository,
    ) {
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $today = now();
        $startOfMonth = $today->copy()->startOfMonth();
        $totalSpentThisMonth = Transaction::whereBetween('date', [$startOfMonth, $today])->sum('value');
        $dailyAverage = round($totalSpentThisMonth / $today->day, 2);

        $categorySums = Category::with([
            'transactions' => function ($query) use ($startOfMonth, $today) {
                $query->whereBetween('date', [$startOfMonth, $today]);
            }
        ])->get()->mapWithKeys(function ($category) {
            return [$category->name => $category->transactions->sum('value')];
        })->sortDesc();

        $topCategoryName = $categorySums->keys()->first();
        $topCategoryTotal = $categorySums->values()->first();

        $categoryChartData = Category::with(['transactions' => function ($query) use ($startOfMonth, $today) {
            $query->whereBetween('date', [$startOfMonth, $today]);
        }])->get()->mapWithKeys(function ($category) {
            return [$category->name => $category->transactions->sum('value')];
        })->sortDesc();

        return view('dashboard', [
            'totalSpentThisMonth' => $totalSpentThisMonth,
            'dailyAverage' => $dailyAverage,
            'topCategoryName' => $topCategoryName,
            'topCategoryTotal' => $topCategoryTotal,
            'categoryChartLabels' => $categoryChartData->keys(),
            'categoryChartValues' => $categoryChartData->values(),
        ]);
    }
}
