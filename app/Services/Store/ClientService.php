<?php

namespace App\Services\Store;

use App\Constant\GeneralConstants;
use App\Models\ClientAddress;
use App\Models\Order;
use App\Models\OrderInfo;
use App\Models\User;
use Spatie\Permission\Models\Role;

class ClientService
{
    private const BILLING_KEY_PREFIX = 'billing_';

    public function findClientByEmail(string $email) {
        return User::where('email', $email)->first();
    }

    public function createClient(array $data)
    {
       return User::create($data);
    }

    public function findOrCreateClient(array $contactDetails): User
    {
        if (!$client = $this->findClientByEmail($contactDetails['email'])) {
            $client = $this->createClient($contactDetails);
            $clientRole = Role::firstOrCreate(['name' => 'Client']);
            $client->assignRole($clientRole);
        }

        return $client;
    }

    public function saveClientAddresses(User $client, array $addressData): void
    {
        if ($address = $client->shippingAddress) {
            $address->update($addressData);
        } else {
            $this->saveAddress($client->id, $addressData);
        }

        if ($addressData['billingSameAsShippingAddress'] !== 'on') {
            $billingAddressData = collect($addressData)->filter(function ($value, $key) {
                return str_starts_with($key, self::BILLING_KEY_PREFIX);
            })->mapWithKeys(function ($value, $key) {
                return [substr($key, strlen(self::BILLING_KEY_PREFIX)) => $value];
            })->toArray();

            if ($billingAddress = $client->billingAddress) {
                $billingAddress->update($billingAddressData);
            } else {
                $this->saveAddress($client->id, $billingAddressData, GeneralConstants::BILLING_ADDRESS_TYPE);
            }
        }
    }

    public function getClientForOrder(array $contactDetails): User
    {
        $client = $this->findOrCreateClient($contactDetails);
        $this->saveClientAddresses($client, $contactDetails);

        return $client;
    }

    private function saveAddress(int $clientId, array $data, string $type = GeneralConstants::SHIPPING_ADDRESS_TYPE): void
    {
        ClientAddress::create(['user_id' => $clientId, 'type' => $type] + $data);
    }

    public function saveClientToOrderInfoHistory(Order $order, User $user): void
    {
        if ($order->orderInfo) return;

        $orderInfo = new OrderInfo();
        $orderInfo->order_id = $order->id;
        $orderInfo->full_name = $user->getFullNameAttribute();
        $orderInfo->phone = $user->phone;
        $orderInfo->email = $user->email;
        $orderInfo->shipping_address = $user->shippingAddress->getFullAddressAttribute();
        $orderInfo->billing_address = $user->billingAddress?->getFullAddressAttribute();
        $orderInfo->save();
    }
}
