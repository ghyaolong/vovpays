<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/11/20
 * Time: 10:13
 */

namespace App\Repositories;

use App\Models\System;
use Illuminate\Support\Facades\Cache;

class SystemsRepository
{
    protected $system;
    public function __construct(System $system)
    {
        $this->system = $system;
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function findId(int $id)
    {
        return $this->system->whereId($id)->first();
    }

    /**安Name获取配置项值
     * @param string $name
     * @return mixed
     */
    static public function findKey(string $name)
    {
        $systems=Cache::get('systems');
        return $systems[$name]->value;
    }

    /**
     * 添加
     * @param array $data
     * @return mixed
     */
    public function add(array $data)
    {
        return $this->system->create($data);
    }

    /**
     * @return mixed
     */
    public function getAll()
    {
        return $this->system->get();
    }

    /**
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, array $data)
    {
        return $this->system->whereId($id)->update($data);
    }
}