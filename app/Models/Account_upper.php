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

}