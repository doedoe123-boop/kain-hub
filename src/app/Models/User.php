<?php

namespace App\Models;

use App\UserRole;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Lunar\Base\LunarUser as LunarUserInterface;
use Lunar\Base\Traits\LunarUser;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser, LunarUserInterface
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, HasRoles, LunarUser, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
        ];
    }

    /**
     * Return the store owned by this user.
     */
    public function store(): HasOne
    {
        return $this->hasOne(Store::class);
    }

    /**
     * Determine if the user is an admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === UserRole::Admin;
    }

    /**
     * Determine if the user is a store owner.
     */
    public function isStoreOwner(): bool
    {
        return $this->role === UserRole::StoreOwner;
    }

    /**
     * Determine if the user is a customer.
     */
    public function isCustomer(): bool
    {
        return $this->role === UserRole::Customer;
    }

    /**
     * Determine if the user can access the given Filament panel.
     *
     * - Admin panel (/admin): admins only
     * - Lunar panel (/lunar): approved store owners only
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return match ($panel->getId()) {
            'admin' => $this->isAdmin(),
            'lunar' => $this->isStoreOwner() && $this->store?->isApproved(),
            default => false,
        };
    }

    /**
     * Accessor used by Lunar's Gate::after callback to grant
     * admin users full access to all Lunar resources.
     */
    public function getAdminAttribute(): bool
    {
        return $this->isAdmin();
    }
}
