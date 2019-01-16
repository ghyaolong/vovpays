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
        $this->accountBankCardsRepository=$accountBankCardsRepository;
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
//        dd($data);
        $data = array_except($data, ['_token']);
        if ($data['accountType'] = "支付宝"){
            $data['channel_payment_id'] = 1;
        } elseif ($data['accountType'] = "微信"){
            $data['channel_payment_id'] = 2;
        }else{
            $data['channel_payment_id'] = 3;
        }

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
        return $this->accountBankCardsRepository->update($id, $uid, $data);
    }


    /**
     * @param int $id
     * @param int $uid
     * @return mixed
     */
    public function findIdAndUserId(int $id, int $uid)
    {
        return $this->accountBankCardsRepository->findIdAndUserId($id,$uid);
    }

}