<?php

namespace App\Services;


use App\Repositories\AdminsRepository;
use App\Repositories\UsersRepository;
use App\Repositories\SystemsRepository;



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
        $PermissionType=SystemsRepository::findKey('PERMISSIONTYPE');
        switch ($PermissionType) {
            case 'SMS':
                $result = SmsPermission::check($code);
                break;
            case 'GOOGLEPAY':
                $result = GooglePermission::check($code);
                break;
            case 'PASSWORD':
                $result = PasswordPermission::check($code);
                break;
            default :
                return false;
        }
        return $result = $result ? false : true;
    }

}
