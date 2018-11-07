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
     * 添加
     * @param array $data
     * @return mixed
     */
    public function add(array $data){
        return $this->admin->create($data);
    }

    /**
     * 获取所有管理员
     * @return mixed
     */
    public function getAdminsList()
    {
        return $this->admin->get();
    }

    /**
     * 修改
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, array $data){
        return $this->admin->whereId($id)->update($data);
    }

    /**
     * 删除
     * @param int $id
     * @return mixed
     */
    public function del(int $id){
        return $this->admin->whereId($id)->delete();
    }


    /**
     * 根据邮箱查询
     * @param string $email
     * @return mixed
     */
    public function findEmail(string $email)
    {
        return $this->admin->whereEmail($email)->first();
    }

    /**
     * 根据用户名查询
     * @param string $username
     * @return mixed
     */
    public function findUsername(string $username)
    {
        return $this->admin->whereUsername($username)->first();
    }

    /**
     * 根据电话查询
     * @param string $phone
     * @return mixed
     */
    public function findPhone(string $phone)
    {
        return $this->admin->wherePhone($phone)->first();
    }

    /**
     * 根据id查询
     * @param string $id
     * @return mixed
     */
    public function findId(string $id)
    {
        return $this->admin->find($id);
    }

    /**
     * 根据电话排除指定id
     * @param string $phone
     * @param int $id
     * @return mixed
     */
    public function findPhoneNotId(string $phone, int $id)
    {
        return $this->admin->wherePhone($phone)->where('id','<>',$id)->first();
    }

    /**
     * 根据用户名排除指定id
     * @param string $username
     * @param int $id
     * @return mixed
     */
    public function findUsernameNotId(string $username, int $id)
    {
        return $this->admin->whereUsername($username)->where('id','<>',$id)->first();
    }

    /**
     * 根据邮箱排除指定id
     * @param string $email
     * @param int $id
     * @return mixed
     */
    public function findEmailNotId(string $email, int $id)
    {
        return $this->admin->whereEmail($email)->where('id','<>',$id)->first();
    }

    /**
     * 检测id和密码是否存在
     * @param string $password
     * @param int $id
     * @return mixed
     */
    public function findIdPasswordExists(int $id, string $password)
    {
        return $this->admin->whereId($id)->wherePassword($password)->exists();
    }

    /**
     * 同步关联更新管理员角色
     * @param int $id
     * @param array|null $data
     * @return mixed
     */
    public function syncUpdateAdminsRole( int $id ,array $data = null)
    {
        return $this->findId($id)->roles()->sync($data);
    }

}