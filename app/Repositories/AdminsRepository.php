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
     * 获取所有
     * @return mixed
     */
    public function getAll()
    {
        return $this->admin->orderBy('id', 'desc')->get();
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
     * @param int $id
     * @return mixed
     */
    public function findId(int $id)
    {
        return $this->admin->whereId($id)->first();
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