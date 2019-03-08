<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recharge extends Model
{

    protected $guarded = ['id','created_at','updated_at'];

    //
    public function User()
    {
        return $this->belongsTo('App\Models\User');
    }
}
