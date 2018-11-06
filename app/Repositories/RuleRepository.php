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
     * @param string $id
     * @param array $data
     * @return mixed
     */
    public function update(string $id, array $data){
        return $this->rule->whereId($id)->update($data);
    }

    /**
     * 删除
     * @param string $id
     * @return mixed
     */
    public function del(string $id){
        return $this->rule->whereId($id)->delete();
    }

    /**
     * 修改状态--是否验证
     * @param string $id
     * @param array $data
     * @return mixed
     */
    public function updateCheck(string $id , array $data)
    {
        return $this->rule->whereId($id)->update($data);
    }

    /**
     * 根据id查询
     * @param string $id
     * @return mixed
     */
    public function findId(string $id)
    {
        return $this->rule->find($id);
    }

}