<?php

namespace App\Models;

use App\ListingType;
use App\PropertyStatus;
use App\PropertyType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property int $store_id
 * @property string $title
 * @property string $slug
 * @property ?string $description
 * @property PropertyType $property_type
 * @property ListingType $listing_type
 * @property PropertyStatus $status
 * @property float $price
 * @property string $price_currency
 * @property ?string $price_period
 * @property ?int $bedrooms
 * @property ?int $bathrooms
 * @property ?int $garage_spaces
 * @property ?float $floor_area
 * @property ?float $lot_area
 * @property ?int $year_built
 * @property ?int $floors
 * @property ?string $address_line
 * @property ?string $barangay
 * @property string $city
 * @property ?string $province
 * @property ?string $zip_code
 * @property ?float $latitude
 * @property ?float $longitude
 * @property ?array $features
 * @property ?array $images
 * @property ?string $video_url
 * @property ?string $virtual_tour_url
 * @property bool $is_featured
 * @property ?\Illuminate\Support\Carbon $published_at
 * @property int $views_count
 */
class Property extends Model
{
    /** @use HasFactory<\Database\Factories\PropertyFactory> */
    use HasFactory;

    use SoftDeletes;

    /** @var list<string> */
    protected $fillable = [
        'store_id',
        'title',
        'slug',
        'description',
        'property_type',
        'listing_type',
        'status',
        'price',
        'price_currency',
        'price_period',
        'bedrooms',
        'bathrooms',
        'garage_spaces',
        'floor_area',
        'lot_area',
        'year_built',
        'floors',
        'address_line',
        'barangay',
        'city',
        'province',
        'zip_code',
        'latitude',
        'longitude',
        'features',
        'images',
        'video_url',
        'virtual_tour_url',
        'is_featured',
        'published_at',
        'views_count',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'property_type' => PropertyType::class,
            'listing_type' => ListingType::class,
            'status' => PropertyStatus::class,
            'price' => 'decimal:2',
            'floor_area' => 'decimal:2',
            'lot_area' => 'decimal:2',
            'features' => 'array',
            'images' => 'array',
            'is_featured' => 'boolean',
            'published_at' => 'datetime',
            'views_count' => 'integer',
        ];
    }

    // ── Boot ───────────────────────────────────────────────────────────

    protected static function booted(): void
    {
        static::creating(function (self $property): void {
            if (empty($property->slug)) {
                $property->slug = Str::slug($property->title).'-'.Str::random(6);
            }
        });
    }

    // ── Relationships ──────────────────────────────────────────────────

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function inquiries(): HasMany
    {
        return $this->hasMany(PropertyInquiry::class);
    }

    // ── Scopes ─────────────────────────────────────────────────────────

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', PropertyStatus::Active);
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true)->active();
    }

    public function scopeForStore(Builder $query, int $storeId): Builder
    {
        return $query->where('store_id', $storeId);
    }

    // ── Helpers ─────────────────────────────────────────────────────────

    /**
     * Get formatted price string.
     */
    public function formattedPrice(): string
    {
        $formatted = $this->price_currency.' '.number_format((float) $this->price, 2);

        if ($this->price_period && $this->listing_type !== ListingType::ForSale) {
            $formatted .= ' / '.$this->price_period;
        }

        return $formatted;
    }

    /**
     * Get the full location string.
     */
    public function fullLocation(): string
    {
        return collect([
            $this->address_line,
            $this->barangay,
            $this->city,
            $this->province,
        ])->filter()->implode(', ');
    }

    /**
     * Increment the views counter.
     */
    public function recordView(): void
    {
        $this->increment('views_count');
    }

    /**
     * Publish the listing.
     */
    public function publish(): void
    {
        $this->update([
            'status' => PropertyStatus::Active,
            'published_at' => $this->published_at ?? now(),
        ]);
    }
}
