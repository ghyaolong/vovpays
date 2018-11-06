<?php

namespace App\Services;
use App\Repositories\AdminsRepository;

class AdminsService
{
    protected $adminsRepository;

    public function __construct(AdminsRepository $adminsRepository)
    {
        $this->adminsRepository = $adminsRepository;
    }

    public function getAdminsList()
    {
        return $this->adminsRepository->getAdminsList();
    }
}