<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $paymentOptions = Auth::user()->paymentOptions->where('balance', '!=', '0')->sortByDesc('balance');

        return view('dashboard', compact('paymentOptions'));
    }
}
