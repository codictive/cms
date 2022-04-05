<?php

namespace Codictive\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    public const PRIORITY_LOW       = 'کم',
     PRIORITY_NORMAL                = 'متوسط',
     PRIORITY_HIGH                  = 'بالا',
     STATUS_PENDING                 = 'در حال بررسی',
     STATUS_ANSWERED                = 'پاسخ داده شده',
     STATUS_CLOSED                  = 'بسته شده',
     DEPARTMENT_MANAGEMENT          = 'مدیریت',
     DEPARTMENT_SUPPORT             = 'پشتیبانی فروش',
     DEPARTMENT_QUOTE               = 'استعلام قیمت',
     DEPARTMENT_FEEDBACK            = 'پیشنهادات و انتقادات';

    public const DEPARTMENT = [
        Ticket::DEPARTMENT_MANAGEMENT,
        Ticket::DEPARTMENT_SUPPORT,
        Ticket::DEPARTMENT_QUOTE,
        Ticket::DEPARTMENT_FEEDBACK,
    ];

    public const PRIORITY = [
        Ticket::PRIORITY_LOW,
        Ticket::PRIORITY_NORMAL,
        Ticket::PRIORITY_HIGH,
    ];

    public const STATUS = [
        Ticket::STATUS_PENDING,
        Ticket::STATUS_ANSWERED,
        Ticket::STATUS_CLOSED,
    ];

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
