<?php

namespace App\Constant;

class OrderStatus
{
    const array STATUSES_FLOW = [
        StatusesConstants::CREATED => [
            StatusesConstants::PROCESSING,
            StatusesConstants::CANCELLED,
            StatusesConstants::RETURNED
        ],
        StatusesConstants::PROCESSING => [
            StatusesConstants::WAITING_PAYMENT,
            StatusesConstants::SHIPPED,
            StatusesConstants::CANCELLED,
            StatusesConstants::RETURNED
        ],
        StatusesConstants::PAID => [
            StatusesConstants::PROCESSING,
            StatusesConstants::SHIPPED,
            StatusesConstants::CANCELLED,
            StatusesConstants::RETURNED
        ],
        StatusesConstants::SHIPPED => [StatusesConstants::DELIVERED],
        StatusesConstants::CANCELLED => [StatusesConstants::REFUNDED],
        StatusesConstants::RETURNED => [StatusesConstants::REFUNDED],
        StatusesConstants::DELIVERED => [],
        StatusesConstants::PAYMENT_FAILURE => [
            StatusesConstants::CANCELLED,
            StatusesConstants::RETURNED
        ],
        StatusesConstants::WAITING_PAYMENT => [
            StatusesConstants::PAID,
            StatusesConstants::CANCELLED,
            StatusesConstants::RETURNED
        ],
        StatusesConstants::REFUNDED => [],
        StatusesConstants::PENDING => []
    ];
}
