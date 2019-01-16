<?php

namespace App\Services;


use App\Repositories\AdminsRepository;
use App\Repositories\UsersRepository;
use App\Repositories\SystemsRepository;
use App\Exceptions\CustomServiceException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;



class UserPermissionServer
{
    protected $adminsRepository;
    protected $usersRepository;


    public function __construct(AdminsRepository $adminsRepository, UsersRepository $usersRepository)
    {
        $this->adminsRepository = $adminsRepository;
        $this->usersRepository = $usersRepository;

    }


    /**操作权限验证
     * @param $code
     * @return bool
     */
    static public function checkPermission($code)
    {
        $PermissionType = SystemsRepository::findKey('withdraw_permission_type');
        switch ($PermissionType) {
            case 'SMS':
                $result = SmsPermission::check($code);
                break;
            case 'GOOGLEPAY':
                $result = GooglePermission::check($code);
                break;
            case 'PASSWORD':
                $result = static::checkPasswordPermission($code);
                break;
            default :
               throw new  CustomServiceException('不存在的验证方式:'.$PermissionType.',请联系平台管理员!');
        }
        return $result;
    }

    /** 支付密码验证
     * @param $code
     * @return boolean
     */
    protected static function checkPasswordPermission($code)
    {
        $uid = Auth::user()->id;
        $uinfo = DB::table('users')->whereId($uid)->first();

        $status=password_verify($code,$uinfo->payPassword ) ? true : false;
        if(!$status){
            throw new CustomServiceException('支付密码不匹配');
        }

    }

}
