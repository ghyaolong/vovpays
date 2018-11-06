<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Statistical extends Model
{

    /**
     * 一对一反向关联用户。
     */
    public function User()
    {
        return $this->belongsTo('App\Models\User');
    }
}
