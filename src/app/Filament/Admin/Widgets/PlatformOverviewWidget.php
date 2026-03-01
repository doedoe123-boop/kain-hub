<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Store;
use App\Models\SupportTicket;
use App\Models\User;
use App\StoreStatus;
use App\TicketStatus;
use App\UserRole;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PlatformOverviewWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Stores', Store::query()->count())
                ->description($this->pendingStoresDescription())
                ->descriptionIcon('heroicon-o-building-storefront')
                ->color('primary'),

            Stat::make('Total Users', User::query()->where('role', '!=', UserRole::Admin)->count())
                ->description('Store Owners & Customers')
                ->descriptionIcon('heroicon-o-users')
                ->color('success'),

            Stat::make('Open Tickets', SupportTicket::query()->where('status', TicketStatus::Open)->count())
                ->description($this->urgentTicketsDescription())
                ->descriptionIcon('heroicon-o-ticket')
                ->color('warning'),
        ];
    }

    private function pendingStoresDescription(): string
    {
        $pending = Store::query()->where('status', StoreStatus::Pending)->count();

        return $pending > 0 ? "{$pending} pending approval" : 'All stores reviewed';
    }

    private function urgentTicketsDescription(): string
    {
        $urgent = SupportTicket::query()
            ->where('status', TicketStatus::Open)
            ->where('priority', 'urgent')
            ->count();

        return $urgent > 0 ? "{$urgent} urgent" : 'No urgent tickets';
    }
}
