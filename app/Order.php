<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'name', 'status', 'email', 'message', 'payment', 'bkashnumber', 'txid',
        'payment_method', 'cod_amount',
        'address', 'city', 'division', 'zip', 'phone', 'shipping', 'paid', 'discount', 'date',
    ];
}
