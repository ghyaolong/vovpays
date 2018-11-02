<?php

namespace App\Repositories;

use App\Models\Rule;

class RuleRepository
{
    protected $rule;

    public function __construct(Rule $rule)
    {
        $this->rule = $rule;
    }

    /**
     * 获取所有
     * @return mixed
     */
    public function getList()
    {
        return $this->rule->orderBy('sort', 'desc')->get();
    }

    /**
     * 添加
     * @param array $data
     * @return mixed
     */
    public function add(array $data){
        return $this->rule->create($data);
    }

    /**
     * 修改
     * @param string $where
     * @param array $data
     * @return mixed
     */
    public function update(string $where, array $data){
        return $this->rule->where($where)->update($data);
    }

    /**
     * 删除
     * @param string $where
     * @return mixed
     */
    public function del(string $where){
        return $this->rule->where($where)->delete();
    }

}