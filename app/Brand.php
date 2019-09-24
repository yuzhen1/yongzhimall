<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Brand extends Model
{
    //
    protected $primaryKey = 'brand_id';
    protected $table = 'shop_brand';
    public $timestamps = false;
}