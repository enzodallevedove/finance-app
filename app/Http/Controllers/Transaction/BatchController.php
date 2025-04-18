<?php

declare(strict_types=1);

namespace App\Http\Controllers\Transaction;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\PaymentOption;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BatchController extends Controller
{
    public function create()
    {
        /**
         * @var \App\Models\User $user
         */
        $user = Auth::user();

        $categories = $user
            ->categories()
            ->whereNull('parent_id')
            ->with('children')
            ->get();

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
}
