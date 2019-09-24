<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $primaryKey = 'id';
    protected $table='shop_order_address';
    public $timestamps = false;
}
