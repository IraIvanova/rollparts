<?php

namespace App\Http\Controllers;

use App\Constant\PagesConstants;
use App\Exceptions\ProductNotFoundException;
use App\Services\Store\ClientService;
use App\Services\Store\GetDataForPageService;
use App\Services\Store\ValidationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function __construct(
        private readonly GetDataForPageService $getDataForPageService,
        private readonly ClientService $clientService,
        private readonly ValidationService $validationService,
    ) {
    }

    /**
     * @throws ProductNotFoundException
     * @throws \ErrorException
     */
    public function account(): View
    {
        return view('store.account', $this->getDataForPageService->getSpecificPageData(PagesConstants::ACCOUNT_PAGE));
    }

    public function updateClientInfo(Request $request): RedirectResponse
    {
        $validator = $this->validationService->getValidatorForAccount($request);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $this->clientService->updateAndGetClient($request->all());

        return redirect()->route('client.account')->with('success', 'Client info updated.');
    }
}
