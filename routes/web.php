<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Auth\ClientAuthController;
use App\Http\Controllers\Store\AsyncController;
use App\Http\Controllers\Store\CartController;
use App\Http\Controllers\Store\PagesController;
use App\Http\Controllers\Store\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PagesController::class, 'homepage'])->name('homepage');
Route::get('/categories', [PagesController::class, 'categories'])->name('categories');
Route::get('/categories/{category}', [PagesController::class, 'category'])->name('category');
Route::get('/product/{product}', [PagesController::class, 'product'])->name('product');
Route::get('/catalog', [PagesController::class, 'catalog'])->name('catalog');
Route::get('/checkout', [PagesController::class, 'checkout'])->name('checkout');
Route::get('/order-confirmation', [PagesController::class, 'orderConfirmation'])->name('orderConfirmation');

Route::get('/info/return-policy', [PagesController::class, 'returnPolicy'])->name('infoReturnPolicy');
Route::get('/info/privacy', [PagesController::class, 'privacy'])->name('infoPrivacy');
Route::get('/info/contact-us', [PagesController::class, 'contactUs'])->name('infoContactUs');
Route::get('/info/faq', [PagesController::class, 'faq'])->name('infoFaq');
Route::get('/info/about-us', [PagesController::class, 'aboutUs'])->name('infoAboutUs');

Route::get('/cart', [PagesController::class, 'cart'])->name('cart');
Route::post('/payment/callback', [PaymentController::class, 'processPaymentCallback'])->name('processPaymentCallback');
Route::get('/payment/check', [PaymentController::class, 'checkPaymentPage'])->name('checkPayment');
Route::post('/createOrder', [CartController::class, 'createOrder'])->name('createOrder');
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('addToCart');
Route::post('/cart/remove', [CartController::class, 'removeFromCart'])->name('removeFromCart');
Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cartUpdateRoute');
Route::post('/applyCoupon', [CartController::class, 'applyCoupon'])->name('applyCoupon');
Route::post('/removeCoupon', [CartController::class, 'removeCoupon'])->name('removeCoupon');

Route::post('/districts', [CartController::class, 'getDistrictsList'])->name('getDistrictsList');

Route::post('/dynamicSearch', [AsyncController::class, 'dynamicSearch'])->name('dynamicSearch');

Route::get('/login', [ClientAuthController::class, 'showLoginForm'])->name('login');
Route::get('/register', [ClientAuthController::class, 'showRegisterForm'])->name('register');
Route::post('/login', [ClientAuthController::class, 'login'])->name('process-login');
Route::post('/register', [ClientAuthController::class, 'register'])->name('process-register');
Route::get('/logout', [ClientAuthController::class, 'logout'])->name('logout');

Route::prefix('client')->group(function () {
    Route::middleware('auth:web')->group(function () {
        Route::get('/account', [AccountController::class, 'account'])->name('client.account');
        Route::post('/client/update', [AccountController::class, 'updateClientInfo'])->name('client.update');
    });
});
