<?php

namespace App\Models;

use App\Constant\OrderStatus;
use App\Constant\StatusesConstants;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public static function getAllowedStatuses(?int $currentStatus): array
    {
        $statuses = $currentStatus ?
            array_merge(OrderStatus::STATUSES_FLOW[$currentStatus], [$currentStatus]) :
            array_merge(OrderStatus::STATUSES_FLOW[StatusesConstants::CREATED], [StatusesConstants::CREATED]);

        return self::whereIntegerInRaw('id', $statuses)->pluck('name', 'id')->toArray();
    }
}
