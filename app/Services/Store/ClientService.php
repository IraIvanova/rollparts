<?php

namespace App\Services\Store;

use App\Models\Client;
use App\Models\ClientAddress;

class ClientService
{
    public function findClientByEmail(string $email) {
        return Client::where('email', $email)->first();
    }

    public function createClient(array $data)
    {
       return Client::create($data);
    }

    public function findOrCreateClient(array $contactDetails): Client
    {
        if (!$client = $this->findClientByEmail($contactDetails['email'])) {
            $client = $this->createClient($contactDetails);
        }

        return $client;
    }

    public function getShippingAddress(Client $client): ?ClientAddress
    {
        return $client->shippingAddress;
    }

    public function saveAddress(Client $client, array $addressData): void
    {
        if ($address = $this->getShippingAddress($client)) {
            $address->update($addressData);
        } else {
            ClientAddress::create(['client_id' => $client->id, 'type' => 'shipping'] + $addressData);
        }
    }
}
