<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * An RSVP for an open house event.
 *
 * @property int $id
 * @property int $open_house_id
 * @property string $name
 * @property string $email
 * @property ?string $phone
 * @property ?string $notes
 * @property string $status
 */
class OpenHouseRsvp extends Model
{
    /** @use HasFactory<\Database\Factories\OpenHouseRsvpFactory> */
    use HasFactory;

    /** @var list<string> */
    protected $fillable = [
        'open_house_id',
        'name',
        'email',
        'phone',
        'notes',
        'status',
    ];

    // ── Relationships ──────────────────────────────────────────────────

    public function openHouse(): BelongsTo
    {
        return $this->belongsTo(OpenHouse::class);
    }

    // ── Scopes ─────────────────────────────────────────────────────────

    public function scopeConfirmed(Builder $query): Builder
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeAttended(Builder $query): Builder
    {
        return $query->where('status', 'attended');
    }

    // ── Helpers ─────────────────────────────────────────────────────────

    public function markAttended(): void
    {
        $this->update(['status' => 'attended']);
    }

    public function markNoShow(): void
    {
        $this->update(['status' => 'no_show']);
    }

    public function cancel(): void
    {
        $this->update(['status' => 'cancelled']);
    }
}
