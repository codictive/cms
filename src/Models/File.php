<?php

namespace Codictive\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class File extends Model
{
    public const STORAGE_DIR = STATIC_DIR . '/files';

    protected $fillable = ['user_id', 'related_type', 'related_id', 'filename', 'caption', 'context', 'kind', 'mimetype', 'size', 'description'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function related(): MorphTo
    {
        return $this->morphTo();
    }
}
