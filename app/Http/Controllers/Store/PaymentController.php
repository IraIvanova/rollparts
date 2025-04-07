<?php

namespace App\Http\Controllers\Store;

use App\Constant\StatusesConstants;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Services\OrderService;
use App\Services\Payment\IyzicoPaymentService;
use DateTime;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentController extends Controller
{
    private const TIMEZONE = 'Europe/Istanbul';

    public function __construct(
        private readonly IyzicoPaymentService $paymentService,
        private readonly OrderService $orderService,
    ) {
    }

    public function checkPaymentPage(Request $request): View
    {
        return view('checkStatus');
    }

    public function processPaymentCallback(Request $request): RedirectResponse
    {
        $token = $request->get('token');
        $response = $this->paymentService->retrieveCheckoutFormPayment($token);

        $payment = Payment::where('token', $token)->first();
        $payment->callback = json_encode($response->getRawResult());
        $payment->status = strtolower($response->getPaymentStatus());
        $payment->transaction_timestamp = $this->convertToTurkeyTime($response->getSystemTime());
        $payment->save();

        $order = $payment->order;
        $status = $payment->status === StatusesConstants::SUCCESSFUL ?
            StatusesConstants::PAID:
            StatusesConstants::PAYMENT_FAILURE;
        $this->orderService->changeOrderStatus($order, $status);

        if ($payment->status === StatusesConstants::SUCCESSFUL) {
            return redirect()->route('orderConfirmation')->with(['orderId' => $order->id]);
        } else {
            $this->orderService->returnProductsToStock($order);

            return redirect()->route('orderConfirmation')->with(['error' => 'Payment failure']);
        }
    }

    private function convertToTurkeyTime($timestampMs): string
    {
        $timestampSec = $timestampMs / 1000;
        $date = new DateTime("@$timestampSec");
        $date->setTimezone(new \DateTimeZone(self::TIMEZONE));

        return $date->format('Y-m-d H:i:s');
    }
}
