<?php

namespace App\Models;

use App\StoreStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $slug
 * @property ?string $description
 * @property ?string $logo
 * @property ?array $address
 * @property ?string $id_type
 * @property ?string $id_number
 * @property ?string $business_permit
 * @property float $commission_rate
 * @property StoreStatus $status
 * @property ?\Illuminate\Support\Carbon $created_at
 * @property ?\Illuminate\Support\Carbon $updated_at
 *
 * @see /skills/store-management.md
 */
class Store extends Model
{
    /** @use HasFactory<\Database\Factories\StoreFactory> */
    use HasFactory;

    /** @var list<string> */
    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'description',
        'logo',
        'address',
        'id_type',
        'id_number',
        'business_permit',
        'commission_rate',
        'status',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'address' => 'array',
            'commission_rate' => 'decimal:2',
            'status' => StoreStatus::class,
        ];
    }

    /**
     * Return the owner relationship.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Return the orders relationship.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Return the payouts relationship.
     */
    public function payouts(): HasMany
    {
        return $this->hasMany(Payout::class);
    }

    /**
     * Determine if the store is approved.
     */
    public function isApproved(): bool
    {
        return $this->status === StoreStatus::Approved;
    }

    /**
     * Get the full login URL for this store's subdomain.
     */
    public function loginUrl(): string
    {
        $scheme = parse_url(config('app.url'), PHP_URL_SCHEME) ?: 'http';
        $domain = config('app.domain');
        $port = parse_url(config('app.url'), PHP_URL_PORT);

        $url = $scheme . '://' . $this->slug . '.' . $domain;

        if ($port) {
            $url .= ':' . $port;
        }

        return $url . '/login';
    }
}
