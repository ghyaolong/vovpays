<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/1/15
 * Time: 17:31
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Account_upper extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id','created_at','updated_at'];

    /**
     * 一对多反向 通道表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Channel()
    {
        return $this->belongsTo('App\Models\Channel');
    }

    /**
     * 一对多反向 支付方式表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Channel_payment()
    {
        return $this->belongsTo('App\Models\Channel_payment');
    }
}