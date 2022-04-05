<?php

namespace Codictive\Cms\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $fillable = [
        'author_name',
        'author_mobile',
        'subject',
        'department',
        'body',
    ];
}
