<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders_items extends Model
{
    protected $fillable=['item_id','item_name','item_qty','item_price'];
}
