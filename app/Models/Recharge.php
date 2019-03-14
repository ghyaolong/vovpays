<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recharge extends Model
{

    protected $guarded = ['id','created_at','updated_at'];

    protected $appends = ['Status'];
    //
    public function User()
    {
        return $this->belongsTo('App\Models\User');
    }

     /**
      * 获取充值状态。
      *
      * @return string
      */
    public function getStatusAttribute()
    {
        switch ($this->pay_status) {
            case 0:
                return '未支付';
            case 1:
                return '已支付';
            case 3:
                return '异常';
        }
    }
}
