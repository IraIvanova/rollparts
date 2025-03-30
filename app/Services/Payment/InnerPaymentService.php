<?php

namespace App\Services\Payment;

use App\Constant\StatusesConstants;
use App\DTO\Payment\BuyerAddressesDTO;
use App\DTO\Payment\BuyerDTO;
use App\DTO\Payment\IyzicoPaymentDTO;
use App\Models\Order;
use App\Models\Payment;
use App\Services\ShoppingCart\ShoppingCart;

class InnerPaymentService
{
    public function createPaymentInfo(Order $order, string $token)
    {
        $payment = new Payment();
        $payment->order_id = $order->id;
        $payment->token = $token;
        $payment->status = StatusesConstants::STARTED;
        $payment->save();
    }

    public function preparePaymentDTO(Order $order, ShoppingCart $cart): IyzicoPaymentDTO
    {
        $client = $order->client;
        $buyer = new BuyerDTO(
            $client->id,
            $client->name,
            $client->lastName,
            $client->phone,
            $client->billingAddress?->fullAddress ?? $client->shippingAddress->fullAddress,
            $client->ip ?? '172.1.1.1',
            trim($client->email),
            'Türkiye',
            $client->shippingAddress->province->name,
            $client->identity
        );

        $addresses = new BuyerAddressesDTO(
            $client->shippingAddress,
            $client->billingAddress ?? $client->shippingAddress
        );

        return new IyzicoPaymentDTO(
            "conversation_$order->id",
            $order->total_price_with_discount,
            $order->id,
            route('processPaymentCallback', $order->id),
            $buyer,
            $addresses,
            $cart
        );
    }
}
