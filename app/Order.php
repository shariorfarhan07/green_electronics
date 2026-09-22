<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /** Ordered progression shown to the customer as a status timeline. */
    const TIMELINE = ['processing', 'shipped', 'delivered'];

    protected $fillable = [
        'user_id', 'name', 'status', 'email', 'message', 'payment', 'bkashnumber', 'txid',
        'payment_method', 'cod_amount',
        'address', 'city', 'division', 'zip', 'phone', 'shipping', 'paid', 'discount', 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(Orders_Items::class, 'order_id');
    }

    public function getGrandTotalAttribute()
    {
        return $this->payment + $this->shipping - ($this->discount ?: 0);
    }

    public function isCancelled()
    {
        return strtolower(trim($this->status)) === 'cancelled';
    }

    /**
     * How far along TIMELINE this order is. The seeded default status
     * ("our representative will call you") counts as not yet started.
     */
    public function timelineStage()
    {
        $index = array_search(strtolower(trim($this->status)), self::TIMELINE, true);

        return $index === false ? 0 : $index + 1;
    }
}
