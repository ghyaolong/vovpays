<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2018/11/1
 * Time: 17:08
 */

namespace App\Repositories;
use App\Models\Admin;

class AdminsRepository
{

    protected $admin;

    /**
     * AdminRepository constructor.
     * @param Admin $admin
     */
    public function __construct( Admin $admin)
    {
        $this->admin = $admin;
    }

    /**
     * 获取所有管理员
     * @return mixed
     */
    public function getAdminList()
    {
        return $this->admin->get();
    }
}