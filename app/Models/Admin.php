<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guard = 'admin';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Admins without a role are treated as Super Admins (backwards compatibility).
     */
    public function isSuperAdmin(): bool
    {
        return $this->role_id === null || ($this->role && $this->role->is_super_admin);
    }

    /**
     * Whether this admin may hand out the given role (to someone else or a new
     * account) — never more access than they have themselves.
     */
    public function canGrantRole(?Role $role): bool
    {
        if ($this->isSuperAdmin()) return true;
        if (!$role || $role->is_super_admin) return false;   // "no role" = Super Admin
        return $this->canGrantPermissions($role->permissions ?? []);
    }

    public function canGrantPermissions(array $permissions): bool
    {
        if ($this->isSuperAdmin()) return true;
        foreach ($permissions as $p) {
            if (!$this->hasPermission($p)) return false;
        }
        return true;
    }

    public function hasPermission(string $permission): bool
    {
        if ($this->isSuperAdmin()) return true;
        return $this->role ? $this->role->hasPermission($permission) : false;
    }
}
