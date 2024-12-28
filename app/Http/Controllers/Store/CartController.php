<?php

namespace App\Http\Controllers\Store;

use App\Exceptions\ProductNotFoundException;
use App\Http\Controllers\Controller;
use App\Services\Store\CartService;
use Illuminate\Http\Request;
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
        $this->cartService->addToCart($request->get('productId'));

        return response()->json([], JsonResponse::HTTP_CREATED);
    }

    public function removeFromCart(Request $request): JsonResponse
    {
        $this->cartService->removeFromCart($request->get('productId'));

        return response()->json([], JsonResponse::HTTP_NO_CONTENT);
    }
}
