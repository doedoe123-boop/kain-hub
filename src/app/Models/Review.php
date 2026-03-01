<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * A customer review for a store or a Lunar product.
 *
 * Uses polymorphic `reviewable` to support:
 *   - Store reviews (reviewable_type = App\Models\Store)
 *   - Product reviews (reviewable_type = Lunar\Models\Product)
 *
 * @property int $id
 * @property int $store_id
 * @property ?int $user_id
 * @property ?string $reviewable_type
 * @property ?int $reviewable_id
 * @property string $reviewer_name
 * @property ?string $reviewer_email
 * @property int $rating
 * @property ?string $title
 * @property string $content
 * @property bool $is_verified_purchase
 * @property bool $is_published
 * @property bool $is_featured
 * @property ?\Illuminate\Support\Carbon $published_at
 */
class Review extends Model
{
    /** @use HasFactory<\Database\Factories\ReviewFactory> */
    use HasFactory;

    /** @var list<string> */
    protected $fillable = [
        'store_id',
        'user_id',
        'reviewable_type',
        'reviewable_id',
        'reviewer_name',
        'reviewer_email',
        'rating',
        'title',
        'content',
        'is_verified_purchase',
        'is_published',
        'is_featured',
        'published_at',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'rating' => 'integer',
            'is_verified_purchase' => 'boolean',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    // ── Relationships ──────────────────────────────────────────────────

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The reviewable entity (Store or Lunar Product).
     */
    public function reviewable(): MorphTo
    {
        return $this->morphTo();
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

    public function scopeStoreReviews(Builder $query): Builder
    {
        return $query->where('reviewable_type', Store::class);
    }

    public function scopeProductReviews(Builder $query): Builder
    {
        return $query->where('reviewable_type', \Lunar\Models\Product::class);
    }

    public function scopeVerifiedPurchase(Builder $query): Builder
    {
        return $query->where('is_verified_purchase', true);
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

    /**
     * Check if this is a store review (not product-specific).
     */
    public function isStoreReview(): bool
    {
        return $this->reviewable_type === Store::class;
    }

    /**
     * Check if this is a product review.
     */
    public function isProductReview(): bool
    {
        return $this->reviewable_type === \Lunar\Models\Product::class;
    }
}
