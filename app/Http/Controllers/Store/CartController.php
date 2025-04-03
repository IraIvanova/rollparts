<?php

namespace App\Http\Controllers\Store;

use App\Constant\StatusesConstants;
use App\Exceptions\AddToCartException;
use App\Exceptions\ProductNotFoundException;
use App\Http\Controllers\Controller;
use App\Services\OrderService;
use App\Services\Payment\InnerPaymentService;
use App\Services\Payment\IyzicoPaymentService;
use App\Services\Store\CartService;
use App\Services\Store\CitiesService;
use App\Services\Store\ClientService;
use App\Services\Store\ValidationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
        //TODO: check when two orders are created subsequently with different users
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
            $order = $this->cartService->createOrder($client);
        } else {
            $this->orderService->updateOrderClient($client, $order);
        }

        $response = $this->paymentService->initializeCheckoutForm(
            $this->innerPaymentService->preparePaymentDTO($order, $cart)
        );

        if ($response->getStatus() == 'success') {
            $this->innerPaymentService->createPaymentInfo($order, $response->getToken());
            $this->orderService->changeOrderStatus($order, StatusesConstants::WAITING_PAYMENT);
            $this->clientService->saveClientToOrderInfoHistory($order, $client);

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
}
