<?php

namespace App\Filament\Widgets;

use App\Models\Review;
use Filament\Widgets\ChartWidget;

class StoreReviewTrendChart extends ChartWidget
{
    protected static ?string $heading = 'Reviews (Last 30 Days)';

    protected static ?int $sort = -2;

    protected static ?string $maxHeight = '280px';

    protected int|string|array $columnSpan = 1;

    protected function getData(): array
    {
        $store = auth()->user()?->getStoreForPanel();

        if (! $store) {
            return ['datasets' => [], 'labels' => []];
        }

        $reviews = Review::forStore($store->id)
            ->published()
            ->where('created_at', '>=', now()->subDays(29)->startOfDay())
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total, AVG(rating) as avg_rating')
            ->groupByRaw('DATE(created_at)')
            ->orderByRaw('DATE(created_at)')
            ->get();

        $labels = [];
        $counts = [];
        $ratings = [];
        $date = now()->subDays(29);

        for ($i = 0; $i < 30; $i++) {
            $dateStr = $date->format('Y-m-d');
            $labels[] = $date->format('M d');

            $row = $reviews->firstWhere('date', $dateStr);
            $counts[] = $row ? (int) $row->total : 0;
            $ratings[] = $row ? round((float) $row->avg_rating, 1) : null;

            $date->addDay();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Reviews',
                    'data' => $counts,
                    'borderColor' => '#10b981',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                    'fill' => true,
                    'tension' => 0.3,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
