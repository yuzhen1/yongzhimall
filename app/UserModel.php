<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    protected $primaryKey = 'user_id';
    protected $table = 'user';
    public $timestamps = false;
}
