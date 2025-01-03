<?php

namespace App\Http\Controllers\Store;

use App\Exceptions\ProductNotFoundException;
use App\Http\Controllers\Controller;
use App\Services\Store\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class CartController extends Controller
{

    public function __construct(private CartService $cartService)
    {
    }

    /**
     * @throws ProductNotFoundException
     */
    public function addToCart(Request $request): JsonResponse
    {
        $this->cartService->addToCart($request->get('productId'), $request->get('amount') ?? 1);

        return response()->json([], JsonResponse::HTTP_CREATED);
    }

    public function removeFromCart(Request $request): JsonResponse
    {
        $this->cartService->removeFromCart($request->get('productId'), (bool)$request->get('removeOne') ?? true);

        return response()->json([], JsonResponse::HTTP_NO_CONTENT);
    }

    public function createOrder(Request $request): RedirectResponse
    {
        $order = $this->cartService->createOrder($request->all());

        return redirect()->route('orderConfirmation')->with(['orderId' => $order->id]);
    }
}
