<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentOption;

class PaymentOptionController extends Controller
{
    public function index()
    {
        $paymentOptions = PaymentOption::orderBy('id','desc')->paginate(5);
        return view('pages.paymentoptions', compact('paymentOptions'));
    }
}
