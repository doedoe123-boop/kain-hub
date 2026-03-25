<?php

namespace App\Models;

use App\InquiryStatus;
use App\Observers\PropertyInquiryObserver;
use Database\Factories\PropertyInquiryFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $property_id
 * @property int $store_id
 * @property ?int $user_id
 * @property ?int $rental_agreement_id
 * @property string $name
 * @property string $email
 * @property ?string $phone
 * @property ?string $message
 * @property InquiryStatus $status
 * @property ?string $agent_notes
 * @property ?Carbon $contacted_at
 * @property ?Carbon $viewing_date
 * @property string $source
 */
#[ObservedBy(PropertyInquiryObserver::class)]
class PropertyInquiry extends Model
{
    /** @use HasFactory<PropertyInquiryFactory> */
    use HasFactory;

    /** @var list<string> */
    protected $fillable = [
        'property_id',
        'store_id',
        'user_id',
        'rental_agreement_id',
        'name',
        'email',
        'phone',
        'message',
        'status',
        'agent_notes',
        'contacted_at',
        'viewing_date',
        'source',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => InquiryStatus::class,
            'contacted_at' => 'datetime',
            'viewing_date' => 'datetime',
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function rentalAgreement(): BelongsTo
    {
        return $this->belongsTo(RentalAgreement::class);
    }

    // ── Scopes ─────────────────────────────────────────────────────────

    public function scopeNew(Builder $query): Builder
    {
        return $query->where('status', InquiryStatus::New);
    }

    public function scopeForStore(Builder $query, int $storeId): Builder
    {
        return $query->where('store_id', $storeId);
    }

    public function scopeOpen(Builder $query): Builder
    {
        return $query->whereNotIn('status', [InquiryStatus::Closed]);
    }

    // ── Helpers ─────────────────────────────────────────────────────────

    public function markContacted(): void
    {
        $this->update([
            'status' => InquiryStatus::Contacted,
            'contacted_at' => now(),
        ]);
    }

    public function scheduleViewing(\DateTimeInterface|string $date): void
    {
        $viewingDate = $date instanceof \DateTimeInterface
            ? Carbon::instance(\DateTimeImmutable::createFromInterface($date))
            : Carbon::parse($date);

        $this->update([
            'status' => InquiryStatus::ViewingScheduled,
            'viewing_date' => $viewingDate,
        ]);
    }

    public function canConvertToRentalAgreement(): bool
    {
        return $this->rental_agreement_id === null
            && in_array($this->status, [InquiryStatus::Negotiating, InquiryStatus::Closed], true);
    }
}
