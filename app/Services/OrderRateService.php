<?php
namespace App\Services;

use App\Models\Channel_payment;
use App\Models\User;
use App\Models\User_rates;

class OrderRateService{
    protected $userRate;   // 商户费率
    protected $runRate;    // 运营费率
    protected $costRate;   // 成本费率
    protected $agentAmount;// 代理收入
    protected $orderFee; // 订单手续费
    protected $amount;   // 订单金额
    /**
     * 订单费用计算
     * @param User $user
     * @param Channel_payment $Channel_payment
     * @param User_rates $user_rates
     * @param float $amount
     */
    public function orderFee(User $user, Channel_payment $Channel_payment, User_rates $user_rates, float $amount)
    {
        $this->userRate = $user_rates->rate;
        $this->runRate  = $Channel_payment->runRate;
        $this->costRate = $Channel_payment->costRate;
        $this->amount   = $amount;
        $this->orderFee = $this->orderPoundage();

//        if($user->parentId != 0)
//        {
            $this->agentOrderPoundage($user->parentId);
//        }
    }

    /**
     * 订单手续费计算
     * @return float
     */
    protected function orderPoundage()
    {
        // 商户费率等于0，走运营费率；商户费率大于运营费率，走运营费率
        if($this->userRate == 0 || $this->userRate > $this->runRate)
        {
            $this->userRate = $this->runRate;
        }
        // 商户费率小于成本费率，走成本费率
        if($this->userRate < $this->costRate )
        {
            $this->userRate = $this->runRate;
        }

        return bcmul($this->userRate,$this->amount,2);
    }

    /**
     * 只计算一级代理收益
     * @param int $agent_id
     */
    public function agentOrderPoundage(int $agent_id)
    {

    }

}