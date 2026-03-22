<?php

namespace App\Models;

use Database\Factories\PayoutLineFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $payout_id
 * @property int $order_id
 * @property int $store_earning Cents
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 */
class PayoutLine extends Model
{
    /** @use HasFactory<PayoutLineFactory> */
    use HasFactory;

    /** @var list<string> */
    protected $fillable = [
        'payout_id',
        'order_id',
        'store_earning',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'store_earning' => 'integer',
        ];
    }

    public function payout(): BelongsTo
    {
        return $this->belongsTo(Payout::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
