<?php

namespace App\Services\Store;

use App\Constant\GeneralConstants;
use App\Models\ClientAddress;
use App\Models\Order;
use App\Models\OrderInfo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class ClientService
{
    private const string BILLING_KEY_PREFIX = 'billing_';

    public function findClientByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
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
            //TODO: make district and province optional for updating info in my account? but not in cart! make separate validation rules
            $address->update($addressData);
        } else {
            $this->saveAddress($client->id, $addressData);
        }

        if (empty($addressData['billingSameAsShippingAddress'])) {
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

    public function updateAndGetClient(array $contactDetails): User
    {
        $client = $this->findOrCreateClient($contactDetails);
        $this->updateClientContactInfo($client, $contactDetails);
        $this->saveClientAddresses($client, $contactDetails);

        return $client;
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

    private function saveAddress(int $clientId, array $data, string $type = GeneralConstants::SHIPPING_ADDRESS_TYPE): void
    {
        ClientAddress::create(['user_id' => $clientId, 'type' => $type] + $data);
    }

    private function updateClientContactInfo(User $client, array $contactDetails): void
    {
        $client->update($contactDetails);
    }

    private function createClient(array $data)
    {
        return User::create($data);
    }
}
