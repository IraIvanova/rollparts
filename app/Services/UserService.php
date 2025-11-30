<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public static function searchClients(string $search): array
    {
        return User::role('client')
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('lastName', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            })
            ->limit(20)
            ->selectRaw("id, CONCAT(name, ' ', lastName, ' (', email, ' - ', phone, ')') as fname")
            ->get()
            ->pluck('fname', 'id')
            ->toArray();
    }
}
