<?php

namespace App\Services;

use App\Repositories\RuleRepository;

class RuleService
{
    protected $ruleRepository;

    public function __construct(RuleRepository $ruleRepository)
    {
        $this->ruleRepository = $ruleRepository;
    }

    /**
     * 获取所有菜单，生成树状
     * @return array
     */
    public function getRuleList()
    {
        $result = $this->ruleRepository->getList();
        return tree($result);
    }

    public function updateCheck(string $id, string $status)
    {
        $data['is_check'] = $status;
        return $this->ruleRepository->updateCheck($id,$data);
    }
}