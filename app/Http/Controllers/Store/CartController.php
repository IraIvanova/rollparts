<?php

namespace App\Http\Controllers\Store;

use App\Constant\PaymentTypeConstants;
use App\Constant\StatusesConstants;
use App\Exceptions\AddToCartException;
use App\Exceptions\ProductNotFoundException;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Services\OrderService;
use App\Services\Payment\InnerPaymentService;
use App\Services\Payment\IyzicoPaymentService;
use App\Services\Store\CartService;
use App\Services\Store\CitiesService;
use App\Services\Store\ClientService;
use App\Services\Store\ValidationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CartController extends Controller
{
    public function __construct(
        private readonly CartService $cartService,
        private readonly CitiesService $citiesService,
        private readonly OrderService $orderService,
        private readonly IyzicoPaymentService $paymentService,
        private readonly InnerPaymentService $innerPaymentService,
        private readonly ClientService $clientService,
        private readonly ValidationService $validationService,
    ) {
    }

    /**
     * @throws ProductNotFoundException
     */
    public function addToCart(Request $request): JsonResponse
    {
        try {
            $data = $this->cartService->addToCart($request->get('productId'), $request->get('amount') ?? 1) +
                ['view' => $this->cartService->getRenderedProductsList()];
            $status = ResponseAlias::HTTP_CREATED;
        } catch (AddToCartException $exception) {
            $data = ['error' => $exception->getMessage()];
            $status = ResponseAlias::HTTP_BAD_REQUEST;
        }

        return response()->json($data, $status);
    }

    public function removeFromCart(Request $request): JsonResponse
    {
        $this->cartService->removeFromCart($request->get('productId'), $request->get('removeOne') ?? true);

        return response()->json([], ResponseAlias::HTTP_NO_CONTENT);
    }

    public function updateCart(): JsonResponse
    {
        return response()->json($this->cartService->getCart(), ResponseAlias::HTTP_CREATED);
    }

    public function createOrder(Request $request): ResponseAlias
    {
        //TODO: check payment status by last attempt
        $validator = $this->validationService->getValidatorForCheckout($request);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $cart = $this->cartService->getCart();

        if ($cart->isEmpty()) {
            return redirect()->back()->withErrors([]);
        }

        $client = $this->clientService->updateAndGetClient($request->all());

        //TODO: save not confirmed orders to temporary table?
        if (!$order = $this->orderService->getOrderByReference($cart->getOrderReference())) {
            $order = $this->cartService->createOrder($client, $request->only('additionalNotes', 'paymentMethod'));
        } else {
            $this->orderService->updateOrderClient($client, $order);
        }

        $this->clientService->saveClientToOrderInfoHistory($order, $client);

        if ($order->payment_method === PaymentTypeConstants::BANK_TRANSFER) {
            $this->finishOrderCreation($order, $client, StatusesConstants::WAITING_BANK_TRANSFER);
            $this->cartService->clearCart();

            return redirect()->route('orderConfirmation')->with(['orderId' => $order->id]);
        }

        $response = $this->paymentService->initializeCheckoutForm(
            $this->innerPaymentService->preparePaymentDTO($order, $cart)
        );

        if ($response->getStatus() == 'success') {
            $this->innerPaymentService->createPaymentInfo($order, $response->getToken());
            $this->finishOrderCreation($order, $client, StatusesConstants::WAITING_ONLINE_PAYMENT);
            $this->cartService->clearCart();

            return redirect($response->getPaymentPageUrl());
        } else {
            return redirect()->route('checkout')->withErrors([$response->getErrorMessage()])->withInput();
        }
    }

    public function getDistrictsList(Request $request): JsonResponse
    {
        return response()->json(
            $this->citiesService->getDistrictsByProvinceId($request->get('provinceId')),
            ResponseAlias::HTTP_OK
        );
    }

    public function applyCoupon(Request $request): RedirectResponse
    {
        $result = $this->cartService->applyCoupon($request->get('coupon'));

        return redirect()->back()->with($result + ['enteredCoupon' => $request->get('coupon')]);
    }

    public function removeCoupon(Request $request): RedirectResponse
    {
        $this->cartService->removeCoupon();

        return redirect()->back();
    }

    private function finishOrderCreation(Order $order, User $client, string $status): void
    {
        $this->orderService->changeOrderStatus($order, $status);
        $this->clientService->saveClientToOrderInfoHistory($order, $client);
    }

    public function loadOrderReviewBlock(Request $request): View
    {
        $isBankTransfer = $request->get('paymentMethod') === PaymentTypeConstants::BANK_TRANSFER;
        $cart = $this->cartService->getCart();
        $shoppingCart = [
            'totalWithDiscount' => $this->orderService->calculateTotalPriceWithDiscount(
                $this->cartService->getCart()->getProducts(),
                $cart->getCouponDiscount(),
                $isBankTransfer
            )
        ] + $this->cartService->getCart()->toArray();

        return view(
            'store.components.checkout.orderReview',
            [
                'isBankTransfer' => $request->get('paymentMethod') === PaymentTypeConstants::BANK_TRANSFER,
            ] + $shoppingCart
        );
    }
}
