<?php

namespace App\Models;

use Database\Factories\LegalPageFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $content
 * @property string $type
 * @property bool $is_published
 * @property ?Carbon $published_at
 * @property ?Carbon $last_reviewed_at
 * @property ?int $updated_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class LegalPage extends Model
{
    /** @use HasFactory<LegalPageFactory> */
    use HasFactory;

    /** @var list<string> */
    protected $fillable = [
        'title',
        'slug',
        'content',
        'type',
        'is_published',
        'published_at',
        'last_reviewed_at',
        'updated_by',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'published_at' => 'datetime',
            'last_reviewed_at' => 'datetime',
        ];
    }

    public function editor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Scope to only published legal pages.
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }
}
