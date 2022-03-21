<?php

namespace Codictive\Cms\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    protected $fillable    = ['name', 'email', 'mobile', 'password'];
    protected $hidden      = ['password'];
    protected $casts       = ['is_active'   => 'boolean', 'is_verified' => 'boolean'];

    /**
     * Fetches User having given email address.
     *
     * @param string[] $with
     */
    public static function byEmail(string $email, array $with = []): User | null
    {
        return User::with($with)->where('email', $email)->first();
    }

    /**
     * Fetches User having given mobile number.
     *
     * @param string[] $with
     */
    public static function byMobile(string $mobile, array $with = []): User | null
    {
        return User::with($with)->where('mobile', $mobile)->first();
    }

    public function sessions(): HasMany
    {
        return $this->hasMany(AuthSession::class);
    }

    public function activities(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_roles')->withTimestamps();
    }

    public function hasPermission(Permission $permission): bool
    {
        foreach ($this->roles as $role) {
            if ($role->hasPermission($permission)) {
                return true;
            }
        }

        return false;
    }
}
