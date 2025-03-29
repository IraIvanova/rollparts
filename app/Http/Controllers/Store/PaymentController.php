<?php

namespace App\Http\Controllers\Store;

use App\Constant\PagesConstants;
use App\Exceptions\ProductNotFoundException;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Services\Store\CartService;
use App\Services\Store\GetDataForPageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function processPaymentCallback(Request $request)
    {
        $payment = new Payment();
        $payment->callback(json_encode($request->all()));
        $payment->save();
    }
}
