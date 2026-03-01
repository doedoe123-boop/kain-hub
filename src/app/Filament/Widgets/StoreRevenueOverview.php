<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Payout;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StoreRevenueOverview extends BaseWidget
{
    protected static ?int $sort = -1;

    protected function getStats(): array
    {
        $store = auth()->user()?->getStoreForPanel();

        if (! $store) {
            return [];
        }

        $totalRevenue = Order::forStore($store->id)
            ->delivered()
            ->sum('store_earning') / 100;

        $totalCommission = Order::forStore($store->id)
            ->delivered()
            ->sum('commission_amount') / 100;

        $pendingPayout = Payout::forStore($store->id)
            ->pending()
            ->sum('amount');

        $paidOut = Payout::forStore($store->id)
            ->paid()
            ->sum('amount');

        // This month's revenue
        $monthRevenue = Order::forStore($store->id)
            ->delivered()
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('store_earning') / 100;

        return [
            Stat::make('Total Revenue', '₱'.number_format($totalRevenue, 2))
                ->description('₱'.number_format($monthRevenue, 2).' this month')
                ->icon('heroicon-o-currency-dollar')
                ->color('success'),

            Stat::make('Commission', '₱'.number_format($totalCommission, 2))
                ->description('Platform fees')
                ->icon('heroicon-o-receipt-percent')
                ->color('warning'),

            Stat::make('Pending Payout', '₱'.number_format($pendingPayout, 2))
                ->description('Awaiting processing')
                ->icon('heroicon-o-banknotes')
                ->color($pendingPayout > 0 ? 'info' : 'gray'),

            Stat::make('Total Paid Out', '₱'.number_format($paidOut, 2))
                ->description('Transferred to your account')
                ->icon('heroicon-o-check-badge')
                ->color('success'),
        ];
    }
}
