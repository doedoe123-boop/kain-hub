<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Daily analytics snapshot for a property listing.
 *
 * @property int $id
 * @property int $property_id
 * @property int $store_id
 * @property \Illuminate\Support\Carbon $date
 * @property int $views
 * @property int $unique_views
 * @property int $inquiries
 * @property int $phone_clicks
 * @property int $email_clicks
 * @property int $share_clicks
 */
class PropertyAnalytic extends Model
{
    /** @use HasFactory<\Database\Factories\PropertyAnalyticFactory> */
    use HasFactory;

    /** @var list<string> */
    protected $fillable = [
        'property_id',
        'store_id',
        'date',
        'views',
        'unique_views',
        'inquiries',
        'phone_clicks',
        'email_clicks',
        'share_clicks',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'date' => 'date',
            'views' => 'integer',
            'unique_views' => 'integer',
            'inquiries' => 'integer',
            'phone_clicks' => 'integer',
            'email_clicks' => 'integer',
            'share_clicks' => 'integer',
        ];
    }

    // ── Relationships ──────────────────────────────────────────────────

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    // ── Scopes ─────────────────────────────────────────────────────────

    public function scopeForStore(Builder $query, int $storeId): Builder
    {
        return $query->where('store_id', $storeId);
    }

    public function scopeForProperty(Builder $query, int $propertyId): Builder
    {
        return $query->where('property_id', $propertyId);
    }

    public function scopeDateRange(Builder $query, string $from, string $to): Builder
    {
        return $query->whereBetween('date', [$from, $to]);
    }

    public function scopeLast30Days(Builder $query): Builder
    {
        return $query->where('date', '>=', now()->subDays(30)->toDateString());
    }

    // ── Static Helpers ──────────────────────────────────────────────────

    /**
     * Record or increment today's analytics for a property.
     *
     * @param  array<string, int>  $increments  e.g. ['views' => 1, 'phone_clicks' => 1]
     */
    public static function record(int $propertyId, int $storeId, array $increments = ['views' => 1]): self
    {
        $today = now()->toDateString();

        $analytic = static::query()
            ->where('property_id', $propertyId)
            ->where('store_id', $storeId)
            ->whereDate('date', $today)
            ->first();

        if (! $analytic) {
            $analytic = static::create([
                'property_id' => $propertyId,
                'store_id' => $storeId,
                'date' => $today,
                'views' => 0,
                'unique_views' => 0,
                'inquiries' => 0,
                'phone_clicks' => 0,
                'email_clicks' => 0,
                'share_clicks' => 0,
            ]);
        }

        foreach ($increments as $column => $amount) {
            $analytic->increment($column, $amount);
        }

        return $analytic->fresh();
    }

    /**
     * Get aggregated totals for a store over a date range.
     *
     * @return array{views: int, unique_views: int, inquiries: int, phone_clicks: int, email_clicks: int, share_clicks: int}
     */
    public static function storeTotals(int $storeId, ?string $from = null, ?string $to = null): array
    {
        $query = static::forStore($storeId);

        if ($from && $to) {
            $query->dateRange($from, $to);
        }

        return [
            'views' => (int) $query->sum('views'),
            'unique_views' => (int) $query->sum('unique_views'),
            'inquiries' => (int) $query->sum('inquiries'),
            'phone_clicks' => (int) $query->sum('phone_clicks'),
            'email_clicks' => (int) $query->sum('email_clicks'),
            'share_clicks' => (int) $query->sum('share_clicks'),
        ];
    }
}
