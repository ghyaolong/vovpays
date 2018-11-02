<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2018/11/1
 * Time: 17:07
 */

namespace App\Services;
use App\Repositories\AdminRepository;

class AdminService
{
    protected $adminRepository;

    /**
     * AdminService constructor.
     * @param AdminRepository $adminRepository
     */
    public function __construct(AdminRepository $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    public function getAdmin(string $name)
    {
        return $this->adminRepository->getAdmin($name);
    }
}