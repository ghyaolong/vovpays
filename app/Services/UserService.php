<?php

namespace App\Services;

use App\Repositories\UsersRepository;
use App\Exceptions\CustomServiceException;

class UserService
{
    protected $usersRepository;

    public function __construct(UsersRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    /**
     * 添加
     * @param array $data
     * @return mixed
     */
    public function add(array $data)
    {
        // 去掉无用数据
        $data = array_except($data, ['id','_token','password_confirmation']);

        // 用户标识等于代理商的时候,没有上级代理
        if($data['groupType'] == '2')
        {
            $data['parentId'] = 0;
            $data['agentName']= '';
        }

        // 用户选着上级代理的时候，检测上级代理是否存在
        if( $data['parentId'] != '0')
        {
            $sql = 'id=? and group_type=?';
            $where['id'] = $data['parentId'];
            $where['group_type'] = 2;
            $agent = $this->usersRepository->searchOne($sql,$where);
            if($agent)
            {
                $data['agentName']= $agent->username;
            }else{
                $data['parentId'] = 0;
                $data['agentName']= '';
            }
        }
        $data['group_type']  = $data['groupType'];
        $data['password']    = bcrypt($data['password']);
        $data['payPassword'] = bcrypt('123456');
        $data['merchant']    = getMerchant(1); // 生成一个假的商户号
        $data['apiKey']      = md5(getOrderId());
        $data =array_except($data,'groupType');
        $user = $this->usersRepository->add($data);

        if(!$user)
        {
            throw new CustomServiceException('会员添加失败！');
        }
        $merchant = getMerchant($user->id);
        $this->usersRepository->update($user->id,['merchant'=>$merchant]);

        // 添加的时候同步更新用户统计表
        $statistical['agent_id'] = $user->parentId;
        $this->usersRepository->saveUpdateUsersStatistical($user, $statistical);

        return $user;
    }

    /**
     * 根据id获取
     * @param string $id
     * @return array
     */
    public function findId(string $id)
    {
        $sql = 'id=?';
        $where['id'] = $id;
        $users = $this->usersRepository->searchOne($sql, $where);
        return $users->toArray();
    }

    /**
     * 根据标识$group_id获取用户分页
     * @param int $group_id
     * @param int $page
     * @return mixed
     */
    public function getAllGroupPage(int $group_id, int $page)
    {
        $sql = ' group_type = ? and status <> 2';
        $where['group_type'] = $group_id;
        return $this->usersRepository->searchPage($sql, $where, $page);
    }

    /**
     * 更新
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, array $data)
    {
        $data = array_except($data, ['id','_token','password_confirmation']);
        $exists = $this->usersRepository->findIdPasswordExists($id,$data['password']);
        if($exists)
        {
            $data = array_except($data, 'password');
        }else{
            $data['password'] = bcrypt($data['password']);
        }

        // 用户标识等于代理商的时候,没有上级代理
        if($data['groupType'] == '2')
        {
            $data['parentId'] = 0;
            $data['agentName']= '';
        }

        // 用户选着上级代理的时候，检测上级代理是否存在
        if( $data['parentId'] != '0')
        {
            $sql = 'id=? and group_type=?';
            $where['id'] = $data['parentId'];
            $where['group_type'] = 2;
            $agent = $this->usersRepository->searchOne($sql,$where);
            if($agent)
            {
                $data['agentName']= $agent->username;
            }else{
                $data['parentId'] = 0;
                $data['agentName']= '';
            }
        }
        $data['group_type']  = $data['groupType'];
        $data = array_except($data,'groupType');

        return $this->usersRepository->update($id, $data);
    }

    /**
     * 根据标识$group_id获取用户
     * @param int $group_id
     * @return mixed
     */
    public function getGroupAll(int $group_id)
    {
        $sql = ' group_type = ?';
        $where['group_type'] = $group_id;
        return $this->usersRepository->search($sql, $where);
    }

    /**
     * 状态变更
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function updateStatus(int $id, array $data){

        return $this->usersRepository->update($id, $data);
    }

    /**
     * 查询
     * @param array $data
     * @param int $page
     * @return mixed
     */
    public function searchPage(array $data, int $page)
    {
        $sql   = ' 1=1 ';
        $where = [];

        if( isset($data['merchant']) && $data['merchant'])
        {
            $sql .= 'and merchant = ?';
            $where['merchant'] = $data['merchant'];
        }

        if( isset($data['username']) && $data['username'])
        {
            $sql .= ' and username = ?';
            $where['username'] = $data['username'];
        }

        if( isset($data['groupType']) && $data['groupType'] != '-1')
        {
            $sql .= ' and group_type = ?';
            $where['group_type'] = $data['groupType'];
        }

        if( isset($data['status']) && $data['status'] != '-1')
        {
            $sql .= ' and status = ?';
            $where['status'] = $data['status'];
        }

        return $this->usersRepository->searchPage($sql, $where, $page);
    }

    /**
     * 伪删除
     * @param int $id
     * @return mixed
     */
    public function destroy(int $id)
    {
        return $this->usersRepository->update($id,['status'=>2]);
    }
}