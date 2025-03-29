<?php

namespace App\Constant;

class StatusesConstants
{
    public const int CREATED = 1;
    public const int PENDING = 2;
    public const int WAITING_PAYMENT = 3;
    public const int PAID = 4;
    public const int PAYMENT_FAILURE = 5;


    //Payments
    public const string STARTED = 'started';
    public const string SUCCESSFUL = 'success';
    public const string FAILED = 'failure';
}
