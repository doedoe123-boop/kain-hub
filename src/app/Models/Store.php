<?php

namespace App\Models;

use App\IndustrySector;
use App\StoreStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $slug
 * @property ?string $login_token
 * @property ?string $description
 * @property ?string $logo
 * @property ?array $address
 * @property ?string $id_type
 * @property ?string $id_number
 * @property ?string $business_permit
 * @property ?array $compliance_documents
 * @property float $commission_rate
 * @property StoreStatus $status
 * @property ?IndustrySector $sector
 * @property ?\Illuminate\Support\Carbon $suspended_at
 * @property ?string $suspension_reason
 * @property ?\Illuminate\Support\Carbon $created_at
 * @property ?\Illuminate\Support\Carbon $updated_at
 *
 * @see /skills/store-management.md
 */
class Store extends Model
{
    /** @use HasFactory<\Database\Factories\StoreFactory> */
    use HasFactory;

    use LogsActivity;
    use SoftDeletes;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'status', 'sector', 'commission_rate', 'suspended_at', 'suspension_reason'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    /** @var list<string> */
    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'login_token',
        'description',
        'logo',
        'address',
        'id_type',
        'id_number',
        'business_permit',
        'compliance_documents',
        'commission_rate',
        'status',
        'sector',
        'suspended_at',
        'suspension_reason',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'address' => 'array',
            'id_number' => 'encrypted',
            'business_permit' => 'encrypted',
            'compliance_documents' => 'encrypted:array',
            'commission_rate' => 'decimal:2',
            'status' => StoreStatus::class,
            'suspended_at' => 'datetime',
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
     * Return the staff members for this store.
     */
    public function staffMembers(): HasMany
    {
        return $this->hasMany(User::class, 'store_id');
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
     * Determine if the store is suspended.
     */
    public function isSuspended(): bool
    {
        return $this->status === StoreStatus::Suspended;
    }

    /**
     * Get the full login URL for this store's subdomain.
     *
     * Includes the unique login token in the path so each store
     * has a non-guessable login URL.
     */
    public function loginUrl(): string
    {
        $scheme = parse_url(config('app.url'), PHP_URL_SCHEME) ?: 'http';
        $domain = config('app.domain');
        $port = parse_url(config('app.url'), PHP_URL_PORT);

        $url = $scheme.'://'.$this->slug.'.'.$domain;

        if ($port) {
            $url .= ':'.$port;
        }

        return $url.'/portal/'.$this->login_token.'/login';
    }

    /**
     * Generate a unique login token for this store.
     *
     * Called during store approval so each store gets
     * its own non-guessable access point.
     */
    public function generateLoginToken(): self
    {
        $this->update([
            'login_token' => 'stk_'.Str::random(24),
        ]);

        return $this;
    }
}
