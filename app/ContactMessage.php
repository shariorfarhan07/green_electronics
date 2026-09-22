<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    /** How many messages one IP may send per rolling day. */
    const DAILY_LIMIT = 2;

    protected $fillable = ['name', 'email', 'subject', 'message', 'ip_address'];

    protected $casts = ['read_at' => 'datetime'];

    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    public function isUnread()
    {
        return $this->read_at === null;
    }

    public static function sentFromIpToday($ip)
    {
        return static::where('ip_address', $ip)
            ->where('created_at', '>=', now()->subDay())
            ->count();
    }
}
