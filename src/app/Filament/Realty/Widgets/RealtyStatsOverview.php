<?php

namespace App\Filament\Realty\Widgets;

use App\Models\Development;
use App\Models\OpenHouse;
use App\Models\Property;
use App\Models\PropertyInquiry;
use App\Models\Testimonial;
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
        $totalDevelopments = Development::forStore($store->id)->active()->count();
        $upcomingOpenHouses = OpenHouse::forStore($store->id)->upcoming()->count();
        $publishedReviews = Testimonial::forStore($store->id)->published()->count();
        $avgRating = Testimonial::forStore($store->id)->published()->avg('rating');
        $avgRatingFormatted = $avgRating ? number_format($avgRating, 1) : '—';

        // Reviews last 7 days for trend
        $recentReviews = Testimonial::forStore($store->id)
            ->published()
            ->where('created_at', '>=', now()->subDays(7))
            ->count();

        return [
            Stat::make('Active Listings', $activeListings)
                ->description("{$totalListings} total")
                ->icon('heroicon-o-home-modern')
                ->color('success'),

            Stat::make('Developments', $totalDevelopments)
                ->description('Active projects')
                ->icon('heroicon-o-building-office-2')
                ->color('warning'),

            Stat::make('New Inquiries', $newInquiries)
                ->description('Awaiting response')
                ->icon('heroicon-o-chat-bubble-left-right')
                ->color($newInquiries > 0 ? 'danger' : 'gray'),

            Stat::make('Avg Rating', $avgRatingFormatted)
                ->description("{$publishedReviews} reviews")
                ->icon('heroicon-o-star')
                ->color($avgRating >= 4 ? 'success' : ($avgRating >= 3 ? 'warning' : 'danger')),

            Stat::make('Open Houses', $upcomingOpenHouses)
                ->description('Upcoming events')
                ->icon('heroicon-o-calendar-days')
                ->color('info'),

            Stat::make('Total Views', number_format($totalViews))
                ->description($recentReviews > 0 ? "{$recentReviews} new reviews this week" : 'Across all listings')
                ->icon('heroicon-o-eye')
                ->color('info'),
        ];
    }
}
