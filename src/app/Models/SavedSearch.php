<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * A saved property search with notification preferences.
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property array $criteria
 * @property string $notify_frequency
 * @property ?\Illuminate\Support\Carbon $last_notified_at
 * @property bool $is_active
 */
class SavedSearch extends Model
{
    /** @use HasFactory<\Database\Factories\SavedSearchFactory> */
    use HasFactory;

    /** @var list<string> */
    protected $fillable = [
        'user_id',
        'name',
        'criteria',
        'notify_frequency',
        'last_notified_at',
        'is_active',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'criteria' => 'array',
            'is_active' => 'boolean',
            'last_notified_at' => 'datetime',
        ];
    }

    // ── Relationships ──────────────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ── Scopes ─────────────────────────────────────────────────────────

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeNeedsNotification(Builder $query, string $frequency): Builder
    {
        return $query->active()
            ->where('notify_frequency', $frequency)
            ->where(function (Builder $q) {
                $q->whereNull('last_notified_at')
                    ->orWhere('last_notified_at', '<', match (true) {
                        default => now()->subDay(),
                    });
            });
    }

    // ── Helpers ─────────────────────────────────────────────────────────

    public function deactivate(): void
    {
        $this->update(['is_active' => false]);
    }

    public function markNotified(): void
    {
        $this->update(['last_notified_at' => now()]);
    }

    /**
     * Build an Eloquent query from the saved criteria.
     */
    public function toPropertyQuery(): Builder
    {
        $query = Property::query()->active();

        $criteria = $this->criteria;

        if (! empty($criteria['property_type'])) {
            $query->where('property_type', $criteria['property_type']);
        }

        if (! empty($criteria['listing_type'])) {
            $query->where('listing_type', $criteria['listing_type']);
        }

        if (! empty($criteria['min_price'])) {
            $query->where('price', '>=', $criteria['min_price']);
        }

        if (! empty($criteria['max_price'])) {
            $query->where('price', '<=', $criteria['max_price']);
        }

        if (! empty($criteria['bedrooms'])) {
            $query->where('bedrooms', '>=', $criteria['bedrooms']);
        }

        if (! empty($criteria['city'])) {
            $query->whereRaw('LOWER(city) LIKE ?', ['%'.strtolower($criteria['city']).'%']);
        }

        if (! empty($criteria['province'])) {
            $query->whereRaw('LOWER(province) LIKE ?', ['%'.strtolower($criteria['province']).'%']);
        }

        return $query;
    }
}
