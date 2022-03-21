<?php

namespace Codictive\Cms\Models;

use Illuminate\Database\Eloquent\Model;

class SystemLog extends Model
{
    public const LEVEL_FATAL = 'FATAL',
        LEVEL_ERROR          = 'ERROR',
        LEVEL_WARNING        = 'WARNING',
        LEVEL_DEBUG          = 'DEBUG',
        LEVEL_INFO           = 'INFO',
        LEVEL_SUCCESS        = 'SUCCESS';

    public const LEVELS = [
        SystemLog::LEVEL_FATAL,
        SystemLog::LEVEL_ERROR,
        SystemLog::LEVEL_WARNING,
        SystemLog::LEVEL_DEBUG,
        SystemLog::LEVEL_INFO,
        SystemLog::LEVEL_SUCCESS,
    ];

    protected $fillable = ['level', 'context', 'path', 'message'];

    public static function log(?string $context, string $level, string $message)
    {
        SystemLog::create([
            'level'   => $level,
            'context' => $context,
            'path'    => sprintf('[%s] %s', request()->getMethod(), request()->path()),
            'message' => $message,
        ]);
    }

    public static function fatal(?string $context, string $message, ...$args)
    {
        SystemLog::log($context, SystemLog::LEVEL_FATAL, sprintf($message, ...$args));
    }

    public static function error(?string $context, string $message, ...$args)
    {
        SystemLog::log($context, SystemLog::LEVEL_ERROR, sprintf($message, ...$args));
    }

    public static function warning(?string $context, string $message, ...$args)
    {
        SystemLog::log($context, SystemLog::LEVEL_WARNING, sprintf($message, ...$args));
    }

    public static function debug(?string $context, string $message, ...$args)
    {
        SystemLog::log($context, SystemLog::LEVEL_DEBUG, sprintf($message, ...$args));
    }

    public static function info(?string $context, string $message, ...$args)
    {
        SystemLog::log($context, SystemLog::LEVEL_INFO, sprintf($message, ...$args));
    }

    public static function success(?string $context, string $message, ...$args)
    {
        SystemLog::log($context, SystemLog::LEVEL_SUCCESS, sprintf($message, ...$args));
    }
}
