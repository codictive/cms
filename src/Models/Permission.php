<?php

namespace Codictive\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    protected $fillable = ['slug', 'description'];

    /**
     * Fetches Permission with given slug from the database.
     *
     * @param string[] $with
     */
    public static function bySlug(string $slug, array $with = []): Permission | null
    {
        return Permission::with($with)->where('slug', $slug)->first();
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_permissions')->withTimestamps();
    }
}
