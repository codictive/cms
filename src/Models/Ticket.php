<?php

namespace Codictive\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    public const PRIORITY_LOW    = 'کم',
     PRIORITY_NORMAL             = 'متوسط',
     PRIORITY_HIGH               = 'بالا',
     STATUS_PENDING              = 'در حال بررسی',
     STATUS_ANSWERED             = 'پاسخ داده شده',
     STATUS_CLOSED               = 'بسته شده',
     DEPARTEMAN_MANAGEMENT       = 'مدیریت',
     DEPARTEMAN_SUPPORT          = 'پشتیبانی فروش',
     DEPARTEMAN_QUOTE            = 'استعلام قیمت',
     DEPARTEMAN_FEEDBACK         = 'پیشنهادات و انتقادات';

    protected $fillable = [
        'user_id',
        'subject',
        'department',
        'priority',
        'status',
    ];

    /**
     * Defines relation with User model.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Defines relation with Conversation model.
     */
    public function conversations(): HasMany
    {
        return $this->hasMany(Conversation::class);
    }
}
