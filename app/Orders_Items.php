<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders_Items extends Model
{
    protected $table = 'orders_items';
    protected $fillable = ['order_id', 'item_id', 'item_name', 'item_price', 'qty'];
}
