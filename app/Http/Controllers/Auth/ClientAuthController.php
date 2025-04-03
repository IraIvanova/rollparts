<?php

namespace App\Http\Controllers\Auth;

use App\Constant\PagesConstants;
use App\Exceptions\ProductNotFoundException;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\User;
use App\Services\Store\CartService;
use App\Services\Store\GetDataForPageService;
use App\Services\Store\ValidationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class ClientAuthController extends Controller
{
    public function __construct(
        private readonly GetDataForPageService $getDataForPageService,
        private readonly ValidationService $validationService,
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
        if (Auth::guard('web')->attempt($request->only('email', 'password'))) {
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
        //TODO: add checkbox to agree with privacy policy
        //TODO: add verification of email on registration
        //TODO: add changing of email and verification of it via email
//        dd($request->all());

        $validator = $this->validationService->getValidatorForRegistration($request);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $client = User::create([
            'name' => $request->get('name'),
            'lastName' => $request->get('lastName'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'password' => Hash::make($request->get('password')),
        ]);

        $clientRole = Role::firstOrCreate(['name' => 'Client']);
        $client->assignRole($clientRole);

        Auth::guard('web')->login($client);

        return redirect()->route('client.account');
    }

    public function logout()
    {
        Auth::guard('client')->logout();

        return redirect('/');
    }
}
