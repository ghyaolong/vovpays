<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2018/11/1
 * Time: 17:08
 */

namespace App\Repositories;

use App\Models\Quota_log;
use App\Models\Statistical;
use Illuminate\Support\Facades\Hash;

class QuotaLogsRepository
{
    protected $quota_log;

    /**
     * UsersRepository constructor.
     * @param Quota_log $quota_log
     */
    public function __construct(Quota_log $quota_log)
    {
        $this->quota_log = $quota_log;
    }

    /**
     * 查询带分页
     * @param array $data
     * @param int $page
     * @return mixed
     */
    public function searchPage(array $data, int $page)
    {
        $sql = ' 1=1 ';
        $where = [];

        if(isset($data['user_id']) && $data['user_id'])
        {
            $sql .= ' and user_id = ?';
            $where['user_id'] = $data['user_id'];
        }
        return $this->quota_log->whereRaw($sql, $where)->orderBy('id', 'desc')->paginate($page);
    }

    /**
     * 添加
     * @param array $data
     * @return mixed
     */
    public function add(array $data)
    {
        return $this->quota_log->create($data);
    }
}