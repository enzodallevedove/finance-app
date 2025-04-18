<?php

declare(strict_types=1);

namespace App\Http\Controllers\Transaction;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\PaymentOption;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

class BatchController extends Controller
{
    public function create()
    {
        /**
         * @var \App\Models\User $user
         */
        $user = Auth::user();

        $userCategories = $user
            ->categories()
            ->whereNull('parent_id')
            ->with('children')
            ->get();

        $categories = $this->buildCategoriesArray($userCategories);

        $paymentOptions = PaymentOption::all();

        return view('transactions.batch', compact('categories', 'paymentOptions'));
    }

    public function store(Request $request)
    {
        foreach ($request->input('transactions', []) as $data) {
            if (!empty($data['name']) && !empty($data['value'])) {
                Transaction::create([
                    'name' => $data['name'],
                    'value' => $data['value'],
                    'date' => $data['date'],
                    'category_id' => $data['category_id'],
                    'paymentoption_id' => $data['payment_option_id'],
                    'user_id' => Auth::id(),
                ]);
            }
        }

        return redirect()->route('transactions.index')->with('success', 'Transações salvas com sucesso!');
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
