<?php

namespace Codictive\Cms\Models;

use Illuminate\Database\Eloquent\Model;

class KeyValue extends Model
{
    protected static $store;
    public $incrementing  = false;
    protected $keyType    = 'string';
    protected $primaryKey = 'key';
    protected $fillable   = ['key', 'value', 'context'];
    protected $casts      = ['value' => 'json'];

    public static function get(string $key): mixed
    {
        null === KeyValue::$store && KeyValue::loadStore();

        return array_key_exists($key, KeyValue::$store)
            ? KeyValue::$store[$key]
            : KeyValue::find($key)->value ?? null;
    }

    public static function set(string $key, mixed $value, string $context = 'system'): mixed
    {
        KeyValue::$store && KeyValue::$store[$key] = $value;
        if (null === $value) {
            KeyValue::where('key', $key)->delete();

            return null;
        }

        ($kv = KeyValue::find($key))
            ? $kv->update(['value' => $value, 'context' => $context])
            : KeyValue::create(['key' => $key, 'value' => $value, 'context' => $context]);

        return $value;
    }

    protected static function loadStore()
    {
        KeyValue::$store = [];
        foreach (KeyValue::where('context', 'system')->get() as $item) {
            KeyValue::$store[$item->key] = $item->value;
        }
    }
}
