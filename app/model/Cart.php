<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $primaryKey = 'id';
    protected $table='shop_cart';
    public $timestamps = false;
}
