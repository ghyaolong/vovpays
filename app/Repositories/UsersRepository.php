<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2018/11/1
 * Time: 17:08
 */

namespace App\Repositories;
use App\Models\User;
use App\Models\Statistical;

class UsersRepository
{

    protected $user;
    protected $statistical;

    /**
     * UsersRepository constructor.
     * @param User $user
     * @param Statistical $statistical
     */
    public function __construct( User $user, Statistical $statistical)
    {
        $this->user         = $user;
        $this->statistical  = $statistical;
    }

    /**
     * 查询
     * @param string $sql
     * @param array $where
     * @param int $page
     * @return mixed
     */
    public function searchPage(string $sql, array $where, int $page)
    {
        return $this->user->whereRaw($sql, $where)->paginate($page);
    }

    /**
     * 添加
     * @param array $data
     * @return mixed
     */
    public function add(array $data){
        return $this->user->create($data);
    }

    /**
     * 获取所有分页
     * @param int $group_id
     * @param int $page
     * @return mixed
     */
    public function getAllPage(int $group_id, int $page)
    {
        return $this->user->whereGroupType($group_id)->paginate($page);
    }

    /**
     * 获取所有
     * @param int $group_id
     * @return mixed
     */
    public function getAll(int $group_id)
    {
        return $this->user->whereGroupType($group_id)->get();
    }

    /**
     * 修改
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, array $data){
        return $this->user->whereId($id)->update($data);
    }

    /**
     * 删除
     * @param int $id
     * @return mixed
     */
    public function del(int $id){
        return $this->user->whereId($id)->delete();
    }

    /**
     * 根据id查询
     * @param string $id
     * @return mixed
     */
    public function findId(string $id)
    {
        return $this->user->find($id);
    }

    /**
     * 根据邮箱查询
     * @param string $email
     * @return mixed
     */
    public function findEmail(string $email)
    {
        return $this->user->whereEmail($email)->first();
    }

    /**
     * 根据用户名查询
     * @param string $username
     * @return mixed
     */
    public function findUsername(string $username)
    {
        return $this->user->whereUsername($username)->first();
    }

    /**
     * 根据电话查询
     * @param string $phone
     * @return mixed
     */
    public function findPhone(string $phone)
    {
        return $this->user->wherePhone($phone)->first();
    }

    /**
     * 根据电话排除指定id
     * @param string $phone
     * @param int $id
     * @return mixed
     */
    public function findPhoneNotId(string $phone, int $id)
    {
        return $this->user->wherePhone($phone)->where('id','<>',$id)->first();
    }

    /**
     * 根据用户名排除指定id
     * @param string $username
     * @param int $id
     * @return mixed
     */
    public function findUsernameNotId(string $username, int $id)
    {
        return $this->user->whereUsername($username)->where('id','<>',$id)->first();
    }

    /**
     * 根据邮箱排除指定id
     * @param string $email
     * @param int $id
     * @return mixed
     */
    public function findEmailNotId(string $email, int $id)
    {
        return $this->user->whereEmail($email)->where('id','<>',$id)->first();
    }

    /**
     * 检测id和密码是否存在
     * @param string $password
     * @param int $id
     * @return mixed
     */
    public function findIdPasswordExists(int $id, string $password)
    {
        return $this->user->whereId($id)->wherePassword($password)->exists();
    }

    /**
     * 根据id和用户标识
     * @param int $id
     * @param int $group
     * @return mixed
     */
    public function findIdGroup(int $id, int $group)
    {
        return $this->user->whereId($id)->whereGroupType($group)->first();
    }

    /**
     * 同步更新用户统计表
     * @param User $user
     * @param array $data
     * @return mixed
     */
    public function saveUpdateUsersStatistical(User $user, array $data)
    {
        $statistical = $this->statistical;
        $statistical = new $statistical($data);
        return $user->Statistical()->save($statistical);
    }
}