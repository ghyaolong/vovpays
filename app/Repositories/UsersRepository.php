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
use Illuminate\Support\Facades\Hash;

class UsersRepository
{

    protected $user;
    protected $statistical;

    /**
     * UsersRepository constructor.
     * @param User $user
     * @param Statistical $statistical
     */
    public function __construct(User $user, Statistical $statistical)
    {
        $this->user = $user;
        $this->statistical = $statistical;
    }

    /**
     * 查询带分页
     * @param string $sql
     * @param array $where
     * @param int $page
     * @return mixed
     */
    public function searchPage(array $data, int $page)
    {
        $sql = ' 1=1 ';
        $where = [];

        if (isset($data['merchant']) && $data['merchant']) {
            $sql .= 'and merchant = ?';
            $where['merchant'] = $data['merchant'];
        }

        if (isset($data['username']) && $data['username']) {
            $sql .= ' and username = ?';
            $where['username'] = $data['username'];
        }

        if (isset($data['groupType']) && $data['groupType'] != '-1') {
            $sql .= ' and group_type = ?';
            $where['group_type'] = $data['groupType'];
        }

        if (isset($data['status']) && $data['status'] != '-1') {
            $sql .= ' and status = ?';
            $where['status'] = $data['status'];
        }

        return $this->user->whereRaw($sql, $where)->orderBy('id', 'desc')->paginate($page);
    }

    public function searchGroupPage(int $group_id, int $page)
    {
        $sql = ' group_type = ? and status <> 2';
        $where['group_type'] = $group_id;
        return $this->user->whereRaw($sql, $where)->orderBy('id', 'desc')->paginate($page);
    }

    public function searchParentPage(int $parentId, int $page)
    {
        $sql = 'parentId=? and status <>2';
        $where['parentId'] = $parentId;
        return $this->user->whereRaw($sql, $where)->orderBy('id', 'desc')->paginate($page);
    }

    /**
     * 查询不带分页
     * @param string $sql
     * @param array $where
     * @return mixed
     */
    public function search(int $group_id)
    {
        $sql = ' group_type = ?';
        $where['group_type'] = $group_id;
        return $this->user->whereRaw($sql, $where)->orderBy('id', 'desc')->get();
    }

    public function findId(int $id)
    {
        return $this->user->whereId($id)->first();
    }

    public function findUser(string $username)
    {
        return $this->user->whereUsername($username)->first();
    }

    /**
     * 查询一条
     * @param string $sql
     * @param array $where
     * @return mixed
     */
//    public function searchOne(string $sql, array $where)
//    {
//        return $this->user->whereRaw($sql, $where)->first();
//    }
    public function searchOne(string $sql, array $where)
    {
        return $this->user->whereRaw($sql, $where)->first();
    }

    /**
     * 添加
     * @param array $data
     * @return mixed
     */
    public function add(array $data)
    {
        return $this->user->create($data);
    }

    /**
     * 修改
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, array $data)
    {
        return $this->user->whereId($id)->update($data);
    }

    /**
     * 删除
     * @param int $id
     * @return mixed
     */
    public function del(int $id)
    {
        return $this->user->whereId($id)->delete();
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

    public function contrastPassword(int $id, string $password)
    {
        $result = $this->user->whereId($id)->first();
        $oldPassword = $result->password;
        return Hash::check($password, $oldPassword);
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