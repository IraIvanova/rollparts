<?php

namespace App\Constant;

class GeneralConstants
{
    public const LANGUAGES = ['tr', 'en'];
    public const AUTH_ROUTES = [
        'client.login',
        'client.register',
        'client.logout',
        'client.process-login',
        'client.process-register',
    ];

    public const SHIPPING_ADDRESS_TYPE = 'shipping';
    public const BILLING_ADDRESS_TYPE = 'billing';
}
