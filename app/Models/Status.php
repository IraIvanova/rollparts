<?php

namespace App\Models;

use App\Constant\OrderStatus;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public static function getAllowedStatuses(int $currentStatus): array
    {
        return self::whereIntegerInRaw('id', array_merge(OrderStatus::STATUSES_FLOW[$currentStatus], [$currentStatus]))->pluck('name', 'id')->toArray();
    }
}
