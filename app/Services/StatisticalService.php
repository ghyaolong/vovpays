<?php

namespace App\Services;

use App\Repositories\StatisticalRepository;
use App\Models\Recharge;
use Illuminate\Support\Facades\DB;

class StatisticalService
{
    protected $statisticalRepository;

    public function __construct(StatisticalRepository $statisticalRepository)
    {
        $this->statisticalRepository = $statisticalRepository;
    }

    /**
     * 根据id获取
     * @param int $uid
     * @return array
     */
    public function findUserId(int $uid)
    {
        return $this->statisticalRepository->findUserId($uid);
    }

    /**
     * 用户余额增加
     * @param int $uid
     * @param float $amount
     * @return mixed
     */
    public function updateUseridBalanceIncrement(array $data)
    {
        DB::connection('mysql')->transaction(function () use ($data) {

            if ($data['balance_type'] == 0) {
                $result=$this->statisticalRepository->updateUseridBalanceIncrement($data['uid'], $data['amount']);
            }elseif($data['balance_type'] == 1) {
                $result=$this->statisticalRepository->updateUseridBalanceDecrement($data['uid'], $data['amount']);
                $data['amount']=-$data['amount'];
            }
            $result&&$result=Recharge::create(['user_id'=>$data['uid'],'recharge_amount'=>$data['amount'],'actual_amount'=>$data['amount'],
                                                   'merchant'=>$data['merchant'],'orderNo'=>'C' . getOrderId(),'orderMk'=>'总后台手动充值','pay_status'=>1 ]);
            if (!$result) {
                throw new CustomServiceException('系统故障,充值失败');
            }
        });
        return true;
    }

    /**
     * 用户充值余额增加
     * @param int $uid
     * @param float $amount
     * @return mixed
     */
    public function updateUseridHandlingFeeBalanceIncrement(int $uid, float $amount)
    {
        return $this->statisticalRepository->updateUseridHandlingFeeBalanceIncrement($uid,$amount);
    }


    /**
     * 用户充值余额减少
     * @param int $uid
     * @param float $amount
     * @return mixed
     */
    public function updateUseridHandlingFeeBalanceDecrement(int $uid, float $amount)
    {
        return $this->statisticalRepository->updateUseridHandlingFeeBalanceDecrement($uid,$amount);
    }
}