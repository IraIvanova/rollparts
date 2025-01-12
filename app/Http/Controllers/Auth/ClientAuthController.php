<?php

namespace App\Http\Controllers\Auth;

use App\Constant\PagesConstants;
use App\Exceptions\ProductNotFoundException;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Services\Store\CartService;
use App\Services\Store\GetDataForPageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ClientAuthController extends Controller
{
    public function __construct(
        private readonly GetDataForPageService $getDataForPageService
    ) {
    }

    /**
     * @throws ProductNotFoundException
     * @throws \ErrorException
     */
    public function showLoginForm(): View
    {
        return view('auth.client-login', $this->getDataForPageService->getSpecificPageData(PagesConstants::LOGIN_PAGE));
    }

    public function login(Request $request): RedirectResponse
    {
        if (Auth::guard('client')->attempt($request->only('email', 'password'))) {
            return redirect()->route('client.account');
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    /**
     * @throws ProductNotFoundException
     * @throws \ErrorException
     */
    public function showRegisterForm(): View
    {
        return view('auth.client-register', $this->getDataForPageService->getSpecificPageData(PagesConstants::REGISTER_PAGE));
    }

    public function register(Request $request): RedirectResponse
    {
//        dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:clients',
            'password' => 'required|string|confirmed|min:6',
        ]);

        $client = Client::create([
            'name' => $request->get('name'),
            'lastName' => $request->get('lastName'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'password' => Hash::make($request->get('password')),
        ]);

        Auth::guard('client')->login($client);

        return redirect()->route('client.account');
    }

    public function logout()
    {
        Auth::guard('client')->logout();

        return redirect('/');
    }
}
