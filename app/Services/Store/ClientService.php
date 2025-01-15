<?php

namespace App\Services\Store;

use App\Models\Client;
use App\Models\ClientAddress;
use App\Models\User;
use Spatie\Permission\Models\Role;

class ClientService
{
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

    public function getShippingAddress(User $client): ?ClientAddress
    {
        return $client->shippingAddress;
    }

    public function saveAddress(User $client, array $addressData): void
    {
        if ($address = $this->getShippingAddress($client)) {
            $address->update($addressData);
        } else {
            ClientAddress::create(['user_id' => $client->id, 'type' => 'shipping'] + $addressData);
        }
    }
}
