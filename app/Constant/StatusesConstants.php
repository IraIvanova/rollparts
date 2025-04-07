<?php

namespace App\Constant;

class StatusesConstants
{
    public const int CREATED = 1;
    public const int PENDING = 2;
    public const int WAITING_PAYMENT = 3;
    public const int PAID = 4;
    public const int PAYMENT_FAILURE = 5;
    public const int PROCESSING = 6;
    public const int SHIPPED = 7;
    public const int DELIVERED = 8;
    public const int CANCELLED = 9;
    public const int RETURNED = 10;
    public const int REFUNDED = 11;
    public const int EXPIRED = 12;

    public const array CANCELLATION_STATUSES = [self::CANCELLED, self::RETURNED];

    //Payments
    public const string STARTED = 'started';
    public const string SUCCESSFUL = 'success';
    public const string FAILED = 'failure';
}
