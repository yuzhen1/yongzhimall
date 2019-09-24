<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Collect extends Model
{
    protected $primaryKey = 'c_id';
    protected $table = 'shop_collect';
    public $timestamps = false;
}
