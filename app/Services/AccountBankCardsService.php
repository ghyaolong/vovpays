<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/1/15
 * Time: 17:33
 */

namespace App\Services;


use App\Repositories\AccountBankCardsRepository;

class AccountBankCardsService
{
    protected $accountBankCardsRepository;

    public function __construct(AccountBankCardsRepository $accountBankCardsRepository)
    {
        $this->accountBankCardsRepository = $accountBankCardsRepository;
    }

    /**
     * 带分页查询
     * @param array $data
     * @param int $page
     * @return mixed
     */
    public function getAllPage(array $data, int $page)
    {
        return $this->accountBankCardsRepository->searchPage($data, $page);
    }

    /**
     * 添加
     * @param array $data
     * @return mixed
     */
    public function add(array $data)
    {
        $data = array_except($data, ['_token'], ['bank']);
        $bank = explode(",", $data['bank_name']);
        $data['bank_name'] = $bank[0];
        $data['bank_mark'] = $bank[1];
        $data['accountType'] = '银行卡';
        $data['channel_payment_id'] = 3;
        return $this->accountBankCardsRepository->add($data);
    }

    /**
     * 根据用户id和表示id修改
     * @param int $id
     * @param int $uid
     * @param array $data
     * @return mixed
     */
    public function update(int $id, int $uid, array $data)
    {
        $data = array_except($data, ['_token']);
        if(isset( $data['bank_name'])){
            $bank = explode(",", $data['bank_name']);
            $data['bank_name'] = $bank[0];
            $data['bank_mark'] = $bank[1];
        }
        return $this->accountBankCardsRepository->update($id, $uid, $data);
    }

    /**
     * @param int $uid
     * @param int $status
     * @return mixed
     */
    public function getStatusAndUserId(int $uid, int $status)
    {
        return $this->accountBankCardsRepository->getStatusAndUserId($uid, $status);
    }

    /**
     * 跟据状态和是否三方挂号
     * @param int $status
     * @param array $uid_arr
     * @return mixed
     */
    public function getStatusAndUidarr(int $status, array $uid_arr)
    {
        return $this->accountBankCardsRepository->getStatusAndUidarr($status, $uid_arr);
    }

    /**
     * @param int $id
     * @param int $uid
     * @return mixed
     */
    public function findIdAndUserId(int $id, int $uid)
    {
        return $this->accountBankCardsRepository->findIdAndUserId($id, $uid);
    }

    /**
     * @param int $id
     * @param int $uid
     * @return mixed
     */
    public function del(int $id, int $uid)
    {
        return $this->accountBankCardsRepository->del($id, $uid);
    }


}