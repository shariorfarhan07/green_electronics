<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    /**
     * Settings are read on nearly every request (checkout gate, storefront banner).
     * View::composer('*') alone re-runs per rendered view, so this in-memory cache
     * (like $navCategories in AppServiceProvider) keeps that to one query per request.
     */
    private static $cache = [];

    public static function get($key, $default = null)
    {
        if (!array_key_exists($key, self::$cache)) {
            $row = self::where('key', $key)->first();
            self::$cache[$key] = $row ? $row->value : null;
        }

        return self::$cache[$key] ?? $default;
    }

    public static function bool($key, $default = false)
    {
        $value = self::get($key);

        if ($value === null) {
            return $default;
        }

        return $value === '1';
    }

    public static function set($key, $value)
    {
        self::updateOrCreate(['key' => $key], ['value' => $value]);
        self::$cache[$key] = $value;
    }
}
