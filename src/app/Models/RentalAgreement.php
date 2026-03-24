<?php

namespace App\Models;

use App\Observers\RentalAgreementObserver;
use App\RentalAgreementStatus;
use Database\Factories\RentalAgreementFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $property_id
 * @property int $store_id
 * @property ?int $tenant_user_id
 * @property string $tenant_name
 * @property string $tenant_email
 * @property ?string $tenant_phone
 * @property int $monthly_rent Stored in cents
 * @property ?int $security_deposit Stored in cents
 * @property Carbon $move_in_date
 * @property ?int $lease_term_months
 * @property ?string $notes
 * @property RentalAgreementStatus $status
 * @property ?string $tenant_questions
 * @property ?string $landlord_response
 * @property ?Carbon $signed_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property ?Carbon $deleted_at
 * @property-read Property $property
 * @property-read Store $store
 * @property-read ?User $tenantUser
 */
#[ObservedBy(RentalAgreementObserver::class)]
class RentalAgreement extends Model
{
    /** @use HasFactory<RentalAgreementFactory> */
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'property_id',
        'store_id',
        'tenant_user_id',
        'tenant_name',
        'tenant_email',
        'tenant_phone',
        'monthly_rent',
        'security_deposit',
        'move_in_date',
        'lease_term_months',
        'notes',
        'status',
        'tenant_questions',
        'landlord_response',
        'signed_at',
    ];

    protected function casts(): array
    {
        return [
            'move_in_date' => 'date',
            'monthly_rent' => 'integer',
            'security_deposit' => 'integer',
            'lease_term_months' => 'integer',
            'signed_at' => 'datetime',
            'status' => RentalAgreementStatus::class,
        ];
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function tenantUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tenant_user_id');
    }

    public function inquiries(): HasMany
    {
        return $this->hasMany(PropertyInquiry::class);
    }
}
