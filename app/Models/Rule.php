<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    protected $fillable = ['title','rule','icon','pid','order','is_check','is_show'];

    /**
     * 获得此菜单所属的角色。
     */
    public function roles()
    {
        return $this->belongsToMany('App\Models\Role');
    }
}
