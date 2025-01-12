<?php

namespace App\Http\Controllers;

use App\Constant\PagesConstants;
use App\Exceptions\ProductNotFoundException;
use App\Services\Store\GetDataForPageService;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function __construct(
        private readonly GetDataForPageService $getDataForPageService
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
}
