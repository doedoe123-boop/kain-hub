<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * A scheduled open house event for a property listing.
 *
 * @property int $id
 * @property int $property_id
 * @property int $store_id
 * @property string $title
 * @property ?string $description
 * @property \Illuminate\Support\Carbon $event_date
 * @property string $start_time
 * @property string $end_time
 * @property ?int $max_attendees
 * @property bool $is_virtual
 * @property ?string $virtual_link
 * @property string $status
 */
class OpenHouse extends Model
{
    /** @use HasFactory<\Database\Factories\OpenHouseFactory> */
    use HasFactory;

    /** @var list<string> */
    protected $fillable = [
        'property_id',
        'store_id',
        'title',
        'description',
        'event_date',
        'start_time',
        'end_time',
        'max_attendees',
        'is_virtual',
        'virtual_link',
        'status',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'is_virtual' => 'boolean',
            'max_attendees' => 'integer',
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

    public function rsvps(): HasMany
    {
        return $this->hasMany(OpenHouseRsvp::class);
    }

    // ── Scopes ─────────────────────────────────────────────────────────

    public function scopeForStore(Builder $query, int $storeId): Builder
    {
        return $query->where('store_id', $storeId);
    }

    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->where('event_date', '>=', now()->toDateString())
            ->where('status', 'scheduled')
            ->orderBy('event_date');
    }

    public function scopeScheduled(Builder $query): Builder
    {
        return $query->where('status', 'scheduled');
    }

    // ── Helpers ─────────────────────────────────────────────────────────

    public function rsvpCount(): int
    {
        return $this->rsvps()->where('status', 'confirmed')->count();
    }

    public function hasCapacity(): bool
    {
        if (! $this->max_attendees) {
            return true;
        }

        return $this->rsvpCount() < $this->max_attendees;
    }

    public function cancel(): void
    {
        $this->update(['status' => 'cancelled']);
    }

    public function complete(): void
    {
        $this->update(['status' => 'completed']);
    }

    /**
     * Get the formatted time range.
     */
    public function timeRange(): string
    {
        return substr($this->start_time, 0, 5).' – '.substr($this->end_time, 0, 5);
    }
}
