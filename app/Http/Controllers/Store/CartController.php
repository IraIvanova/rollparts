<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Services\Store\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function __construct(private CartService $cartService)
    {
    }

    public function addToCart(Request $request)
    {
        dd($request->all());
        $this->cartService->addToCart($request->get('productId'));
    }
}
