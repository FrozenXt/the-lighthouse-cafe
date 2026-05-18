<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'type',
    ];

    public static function get($key, $default = null)
    {
        return optional(self::where('key', $key)->first())->value ?? $default;
    }

    public static function set($key, $value, $type = 'text')
    {
        return self::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'type' => $type]
        );
    }
    public static function getValue($key, $default = null)
    {
        return optional(self::where('key', $key)->first())->value ?? $default;
    }
}
