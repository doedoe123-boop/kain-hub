<?php

namespace App\Filament\Widgets;

use App\Models\Review;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StoreStatsOverview extends BaseWidget
{
    protected static ?int $sort = -3;

    protected function getStats(): array
    {
        $store = auth()->user()?->getStoreForPanel();

        if (! $store) {
            return [];
        }

        $totalReviews = Review::forStore($store->id)->published()->count();
        $avgRating = Review::forStore($store->id)->published()->avg('rating');
        $avgRatingFormatted = $avgRating ? number_format($avgRating, 1) : '—';

        $storeReviews = Review::forStore($store->id)->published()->storeReviews()->count();
        $productReviews = Review::forStore($store->id)->published()->productReviews()->count();
        $pendingReviews = Review::forStore($store->id)->where('is_published', false)->count();

        // Recent trend
        $recentReviews = Review::forStore($store->id)
            ->published()
            ->where('created_at', '>=', now()->subDays(7))
            ->count();

        return [
            Stat::make('Avg Rating', $avgRatingFormatted)
                ->description("{$totalReviews} total reviews")
                ->icon('heroicon-o-star')
                ->color($avgRating >= 4 ? 'success' : ($avgRating >= 3 ? 'warning' : ($avgRating ? 'danger' : 'gray'))),

            Stat::make('Store Reviews', $storeReviews)
                ->description('About your store')
                ->icon('heroicon-o-building-storefront')
                ->color('info'),

            Stat::make('Product Reviews', $productReviews)
                ->description('On your products')
                ->icon('heroicon-o-shopping-bag')
                ->color('success'),

            Stat::make('Pending Moderation', $pendingReviews)
                ->description($recentReviews > 0 ? "{$recentReviews} new this week" : 'No new reviews')
                ->icon('heroicon-o-clock')
                ->color($pendingReviews > 0 ? 'warning' : 'gray'),
        ];
    }
}
