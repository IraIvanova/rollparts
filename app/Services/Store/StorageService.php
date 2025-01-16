<?php

namespace App\Services\Store;

use Illuminate\Support\Facades\Cache;

class StorageService
{
    private const CACHE_DURATION = 86400;

    public function setValueToStorage(string $key, mixed $value): void
    {
        Cache::put($key, json_encode($value), self::CACHE_DURATION);
    }

    public function getValueFromStorage(string $key): mixed
    {
        return json_decode(Cache::get($key), true);
    }

    public function checkKeyIsInStorage(string $key): string
    {
        return Cache::has($key);
    }
}
