<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * A client testimonial / review for a store or specific property.
 *
 * @property int $id
 * @property int $store_id
 * @property ?int $property_id
 * @property string $client_name
 * @property ?string $client_email
 * @property ?string $client_photo
 * @property int $rating
 * @property string $content
 * @property bool $is_featured
 * @property bool $is_published
 * @property ?\Illuminate\Support\Carbon $published_at
 */
class Testimonial extends Model
{
    /** @use HasFactory<\Database\Factories\TestimonialFactory> */
    use HasFactory;

    /** @var list<string> */
    protected $fillable = [
        'store_id',
        'property_id',
        'client_name',
        'client_email',
        'client_photo',
        'rating',
        'content',
        'is_featured',
        'is_published',
        'published_at',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'rating' => 'integer',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    // ── Relationships ──────────────────────────────────────────────────

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    // ── Scopes ─────────────────────────────────────────────────────────

    public function scopeForStore(Builder $query, int $storeId): Builder
    {
        return $query->where('store_id', $storeId);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true)->published();
    }

    // ── Helpers ─────────────────────────────────────────────────────────

    public function publish(): void
    {
        $this->update([
            'is_published' => true,
            'published_at' => $this->published_at ?? now(),
        ]);
    }

    public function unpublish(): void
    {
        $this->update(['is_published' => false]);
    }

    /**
     * Get star rating as visual string.
     */
    public function starRating(): string
    {
        return str_repeat('★', $this->rating).str_repeat('☆', 5 - $this->rating);
    }
}
