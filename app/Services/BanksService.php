<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/11/17
 * Time: 13:54
 */

namespace App\Services;


use App\Repositories\BanksRepository;

class BanksService
{
    protected $bankCardRepository;

    public function __construct(BanksRepository $banksRepository)
    {
        $this->bankCardRepository = $banksRepository;
    }





    /**
     * 获取一条数据
     * @param int $id
     * @return mixed
     */
    public function findId(int $id)
    {
        return $this->bankCardRepository->findId($id);
    }

    /**
     * 获取状态为1的银行卡
     * @param int $user_id
     * @return mixed
     */
    public function findAll()
    {
        return  $this->bankCardRepository->findStatus();
    }

    /**
     * 编辑
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, array $data)
    {
        $data = array_except($data, ['id', '_token', 'user_id']);
        return $this->bankCardRepository->update($id, $data);
    }

    /**
     * 变更状态
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function updateStatus(int $id, array $data)
    {

        if ($this->bankCardRepository->findStatus($data['user_id'])) {

            $this->bankCardRepository->updateStatus($data['user_id'], ['status' => 0]);
        }

        return $this->bankCardRepository->update($id, $data);
    }

}