<?php

namespace App\Filament\Widgets;

use App\Models\Review;
use Filament\Widgets\ChartWidget;

class StoreRatingDistributionChart extends ChartWidget
{
    protected static ?string $heading = 'Rating Distribution';

    protected static ?int $sort = -2;

    protected static ?string $maxHeight = '280px';

    protected int|string|array $columnSpan = 1;

    protected function getData(): array
    {
        $store = auth()->user()?->getStoreForPanel();

        if (! $store) {
            return ['datasets' => [], 'labels' => []];
        }

        $counts = [];
        for ($rating = 5; $rating >= 1; $rating--) {
            $counts[] = Review::forStore($store->id)
                ->published()
                ->where('rating', $rating)
                ->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Reviews',
                    'data' => $counts,
                    'backgroundColor' => [
                        '#10b981', // 5 stars
                        '#34d399', // 4 stars
                        '#fbbf24', // 3 stars
                        '#f97316', // 2 stars
                        '#ef4444', // 1 star
                    ],
                    'borderColor' => 'transparent',
                    'borderRadius' => 4,
                ],
            ],
            'labels' => ['5 Stars', '4 Stars', '3 Stars', '2 Stars', '1 Star'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'indexAxis' => 'y',
            'scales' => [
                'x' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'stepSize' => 1,
                    ],
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
            ],
        ];
    }
}
