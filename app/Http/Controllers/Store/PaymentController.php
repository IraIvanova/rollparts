<?php

namespace App\Http\Controllers\Store;

use App\Constant\StatusesConstants;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Services\OrderService;
use App\Services\Payment\IyzicoPaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(
        private readonly IyzicoPaymentService $paymentService,
        private readonly OrderService $orderService,
    ) {
    }

    public function checkPaymentPage(Request $request) {
        return view('checkStatus');
    }

    public function processPaymentCallback(Request $request)
    {
        $token = $request->get('token');

        $response = $this->paymentService->retrieveCheckoutFormPayment($token);

        $payment = Payment::where('token', $token)->first();
        $payment->callback = json_encode($response->getRawResult());
        $payment->status = strtolower($response->getPaymentStatus());
        $payment->save();

        $order = $payment->order;
        $status = $payment->status === StatusesConstants::SUCCESSFUL ?
            StatusesConstants::PAID:
            StatusesConstants::PAYMENT_FAILURE;

        $this->orderService->changeOrderStatus($order, $status);

        //TODO: if payment was unsuccessful should we cancel order and return products to stock?
        if ($payment->status === StatusesConstants::SUCCESSFUL) {
            return redirect()->route('orderConfirmation')->with(['orderId' => $order->id]);
        } else {
            return redirect()->route('orderConfirmation')->with(['error' => 'Payment failure']);
        }
    }
}
