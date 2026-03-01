<?php

namespace App\Filament\Realty\Widgets;

use App\Models\Property;
use App\Models\PropertyInquiry;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class RealtyStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $store = auth()->user()?->getStoreForPanel();

        if (! $store) {
            return [];
        }

        $totalListings = Property::forStore($store->id)->count();
        $activeListings = Property::forStore($store->id)->active()->count();
        $newInquiries = PropertyInquiry::forStore($store->id)->new()->count();
        $totalViews = Property::forStore($store->id)->sum('views_count');

        return [
            Stat::make('Total Listings', $totalListings)
                ->description('All properties')
                ->icon('heroicon-o-home-modern')
                ->color('primary'),

            Stat::make('Active Listings', $activeListings)
                ->description('Currently published')
                ->icon('heroicon-o-check-circle')
                ->color('success'),

            Stat::make('New Inquiries', $newInquiries)
                ->description('Awaiting response')
                ->icon('heroicon-o-chat-bubble-left-right')
                ->color($newInquiries > 0 ? 'danger' : 'gray'),

            Stat::make('Total Views', number_format($totalViews))
                ->description('Across all listings')
                ->icon('heroicon-o-eye')
                ->color('info'),
        ];
    }
}
