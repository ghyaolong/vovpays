<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class User_rates extends Pivot
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id','created_at','updated_at'];
}
