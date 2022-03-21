<?php

namespace Codictive\Cms\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    public const ACTION_REGISTER = 'auth.register',
        ACTION_LOGIN             = 'auth.login',
        ACTION_LOGOUT            = 'auth.logout',
        ACTION_RESET_PASSWORD    = 'auth.reset_password';

    public const ACTIONS = [
        ActivityLog::ACTION_REGISTER,
        ActivityLog::ACTION_LOGIN,
        ActivityLog::ACTION_LOGOUT,
        ActivityLog::ACTION_RESET_PASSWORD,
    ];

    protected $fillable = ['user_id', 'related_type', 'related_id', 'action', 'context', 'data', 'notes'];

    /**
     * Fetches ActivityLog having given User and action.
     */
    public static function actionsOfUser(User $user, string $action, array $with = []): Collection
    {
        $operator = Str::contains($action, '%') ? 'LIKE' : '=';

        return ActivityLog::with($with)->where('user_id', $user->id)->where('action', $operator, $action)->get();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function related(): MorphTo
    {
        return $this->morphTo();
    }
}
