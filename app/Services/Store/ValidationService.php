<?php

namespace App\Services\Store;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ValidationService
{
    public function getValidatorForAccount(Request $request): \Illuminate\Validation\Validator
    {
        return Validator::make($request->all(), $this->getCommonRulesForCheckingUserData(), __('validation'));
    }

    public function getValidatorForCheckout(Request $request): \Illuminate\Validation\Validator
    {
        return Validator::make($request->all(), [
            'identity' => ['required', 'string', 'min:2', 'max:50'],
            'district_id' => ['required'],
            'province_id' => ['required'],
            'address_line1' => ['required','string', 'min:2'],
            'zip' => ['required'],
        ] + $this->getCommonRulesForCheckingUserData(), __('validation'));
    }

    public function getValidatorForRegistration(Request $request): \Illuminate\Validation\Validator
    {
        return Validator::make($request->all(), [
            'password' => 'required|string|confirmed|min:6'] + $this->getCommonRulesForCheckingUserData(), __('validation'));
    }

    private function getCommonRulesForCheckingUserData(): array
    {
        return [
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'regex:/^\+?90\d{10}$/'],
            'name' => ['required', 'string', 'min:2', 'max:50'],
            'lastName' => ['required', 'string', 'min:2', 'max:50'],
        ];
    }
}
