<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey = 'order_id';
    protected $table='shop_order';
    public $timestamps = false;
}
