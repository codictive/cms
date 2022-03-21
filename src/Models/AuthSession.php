<?php

namespace Codictive\Cms\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuthSession extends Model
{
    protected $fillable = ['user_id', 'email', 'token', 'ip'];
    protected $casts    = ['last_seen_at' => 'datetime'];

    /**
     * Fetches AuthSession from the database having given token.
     *
     * @param string[] $with
     */
    public static function byToken(string $token, array $with = []): AuthSession | null
    {
        $session = AuthSession::with($with)->where('token', $token)
            ->where('created_at', '>=', Carbon::now()
            ->subDays((int) kv('auth.session_expire_days')))->first();

        $session && $session->updateLastSeen();

        return $session;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function updateLastSeen()
    {
        $this->last_seen_at = Carbon::now();
        $this->save();
    }
}
