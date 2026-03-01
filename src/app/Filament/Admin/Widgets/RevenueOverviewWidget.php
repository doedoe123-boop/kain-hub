<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Order;
use App\Models\Payout;
use App\OrderStatus;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class RevenueOverviewWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        $totalRevenue = Order::query()
            ->where('status', OrderStatus::Delivered)
            ->sum('platform_earning') / 100;

        $pendingPayouts = Payout::query()
            ->where('status', Payout::STATUS_PENDING)
            ->sum('amount');

        $paidPayouts = Payout::query()
            ->where('status', Payout::STATUS_PAID)
            ->sum('amount');

        $activeOrders = Order::query()
            ->active()
            ->count();

        return [
            Stat::make('Platform Revenue', '₱'.Number::format($totalRevenue, 2))
                ->description('From delivered orders')
                ->descriptionIcon('heroicon-o-currency-dollar')
                ->color('success'),

            Stat::make('Pending Payouts', '₱'.Number::format($pendingPayouts, 2))
                ->description(Payout::pending()->count().' payouts awaiting')
                ->descriptionIcon('heroicon-o-clock')
                ->color('warning'),

            Stat::make('Paid Out', '₱'.Number::format($paidPayouts, 2))
                ->description(Payout::paid()->count().' payouts completed')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('info'),

            Stat::make('Active Orders', $activeOrders)
                ->description('Not yet delivered or cancelled')
                ->descriptionIcon('heroicon-o-arrow-path')
                ->color('primary'),
        ];
    }
}
