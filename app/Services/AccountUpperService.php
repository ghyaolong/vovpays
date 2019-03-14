<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/1/15
 * Time: 17:33
 */

namespace App\Services;

use App\Repositories\AccountUpperRepository;

class AccountUpperService
{
    protected $accountUpperRepository;

    public function __construct(AccountUpperRepository $accountUpperRepository)
    {
        $this->accountUpperRepository = $accountUpperRepository;
    }

    /**
     * 带分页查询
     * @param array $data
     * @param int $page
     * @return mixed
     */
    public function getAllPage(int $page)
    {
        return $this->accountUpperRepository->getAllPage($page);
    }

    /**
     * 添加
     * @param array $data
     * @return mixed
     */
    public function add(array $data)
    {
        $data = array_except($data, ['_token']);

        return $this->accountUpperRepository->add($data);
    }

    /**
     * 更新
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, array $data)
    {
        $data = array_except($data, ['id','_token']);

        return $this->accountUpperRepository->update($id, $data);
    }

    /**
     * 根据id查询
     * @param string $id
     * @return mixed
     */
    public function findId(string $id)
    {
        return $this->accountUpperRepository->findId($id);
    }

    public function findChannelId(int $channel_id)
    {
        return $this->accountUpperRepository->findChannelId($channel_id);
    }

    public function findChannelPaymentId(int $channel_payment_id)
    {
        return $this->accountUpperRepository->findChannelPaymentId($channel_payment_id);
    }

    /**
     * 伪删除
     * @param int $id
     * @return mixed
     */
    public function destroy(int $id)
    {
        return $this->accountUpperRepository->del($id);
    }


}