<?php

namespace Codictive\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    protected $fillable = ['name', 'slug'];

    /**
     * Fetches Role having given slug.
     *
     * @param string[] $with
     */
    public static function bySlug(string $slug, array $with = []): Role | null
    {
        return Role::with($with)->where('slug', $slug)->first();
    }

    /**
     * Fetches guest Role from the database.
     */
    public static function guest(array $with = []): Role | null
    {
        return Role::bySlug(kv('auth.guest_role'), $with);
    }

    /**
     * Fetches default Role from the database.
     */
    public static function default(array $with = []): Role | null
    {
        return Role::bySlug(kv('auth.default_role'), $with);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_roles')->withTimestamps();
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_permissions')->withTimestamps();
    }

    public function hasPermission(Permission $permission): bool
    {
        return $this->permissions->contains($permission->id);
    }
}
