<?php

namespace App\Http\Controllers\Store;

use App\Exceptions\AddToCartException;
use App\Exceptions\ProductNotFoundException;
use App\Http\Controllers\Controller;
use App\Services\Store\CartService;
use App\Services\Store\CitiesService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CartController extends Controller
{

    public function __construct(
        private readonly CartService $cartService,
        private readonly CitiesService $citiesService,
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

    public function createOrder(Request $request): RedirectResponse
    {
        $order = $this->cartService->createOrder($request->all());

        return redirect()->route('orderConfirmation')->with(['orderId' => $order->id]);
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
