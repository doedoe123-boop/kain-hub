<?php

namespace App\Filament\Realty\Widgets;

use App\Models\Testimonial;
use Filament\Widgets\ChartWidget;

class RatingDistributionChart extends ChartWidget
{
    protected static ?string $heading = 'Rating Distribution';

    protected static ?int $sort = 3;

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
            $counts[] = Testimonial::forStore($store->id)
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
                        '#10b981', // 5 stars - emerald
                        '#34d399', // 4 stars - emerald light
                        '#fbbf24', // 3 stars - amber
                        '#f97316', // 2 stars - orange
                        '#ef4444', // 1 star - red
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
