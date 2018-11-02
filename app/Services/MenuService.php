<?php

namespace App\Services;

use App\Repositories\RuleRepository;

class MenuService
{
    protected $repository;

    public function __construct(RuleRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getMenuList()
    {
        $result = $this->repository->getList();

        return tree($result);
    }
}