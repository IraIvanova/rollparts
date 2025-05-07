<?php

namespace App\Filament\Widgets;

use App\Constant\StatusesConstants;
use App\Models\Order;
use App\Models\Payment;
use App\Models\ProductStock;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class QuickStats extends BaseWidget
{
    protected function getCards(): array
    {
        $startOfMonth = Carbon::now()->startOfMonth();

        return [
            Stat::make('Total Orders (This Month)', Order::where('created_at', '>=', $startOfMonth)->count())
                ->description('Orders since ' . $startOfMonth->format('M d'))
                ->icon('heroicon-o-shopping-cart'),

            Stat::make('Pending Orders', Order::where('status_id', StatusesConstants::PENDING)->count())
                ->description('Awaiting fulfillment')
                ->color('warning')
                ->icon('heroicon-o-clock'),
//
            Stat::make('Successful Payments', Order::where('status_id', StatusesConstants::PAID)->count())
                ->description('Completed transactions')
                ->color('success')
                ->icon('heroicon-o-currency-dollar'),
//
//            Stat::make('Unconfirmed Payments', Payment::whereNull('media')->orWhere('status', 'pending')->count())
//                ->description('Awaiting confirmation')
//                ->color('warning')
//                ->icon('heroicon-o-document-text'),
//
            Stat::make('Low Inventory', ProductStock::where('quantity', '<', 5)->count())
                ->color('warning')
                ->icon('heroicon-o-exclamation-circle'),
        ];
    }
}

