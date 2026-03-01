<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StoreOrdersOverview extends BaseWidget
{
    protected static ?int $sort = -2;

    protected function getStats(): array
    {
        $store = auth()->user()?->getStoreForPanel();

        if (! $store) {
            return [];
        }

        $totalOrders = Order::forStore($store->id)->count();
        $pendingOrders = Order::forStore($store->id)->pending()->count();
        $activeOrders = Order::forStore($store->id)->active()->count();
        $deliveredOrders = Order::forStore($store->id)->delivered()->count();

        $todayOrders = Order::forStore($store->id)
            ->whereDate('created_at', today())
            ->count();

        return [
            Stat::make('Total Orders', $totalOrders)
                ->description($todayOrders.' today')
                ->icon('heroicon-o-shopping-bag')
                ->color('primary'),

            Stat::make('Pending', $pendingOrders)
                ->description('Awaiting confirmation')
                ->icon('heroicon-o-clock')
                ->color($pendingOrders > 0 ? 'warning' : 'gray'),

            Stat::make('Active', $activeOrders)
                ->description('In progress')
                ->icon('heroicon-o-arrow-path')
                ->color($activeOrders > 0 ? 'info' : 'gray'),

            Stat::make('Delivered', $deliveredOrders)
                ->description('Successfully fulfilled')
                ->icon('heroicon-o-check-circle')
                ->color('success'),
        ];
    }
}
