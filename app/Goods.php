<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Goods extends Model
{
    //
    protected $primaryKey = 'goods_id';
    protected $table = 'shop_goods';
    public $timestamps = false;
}