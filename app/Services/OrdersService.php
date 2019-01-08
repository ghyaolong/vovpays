<?php

namespace App\Services;

use App\Models\User;
use App\Models\Channel;
use App\Models\Channel_payment;
use App\Models\User_rates;
use App\Repositories\OrdersRepository;
use App\Services\OrderRateService;
use Illuminate\Http\Request;

class OrdersService
{
    protected $ordersRepository;
    protected $orderRateService;

    public function __construct(OrdersRepository $ordersRepository, OrderRateService $orderRateService)
    {
        $this->ordersRepository = $ordersRepository;
        $this->orderRateService = $orderRateService;
    }

    /**
     * @param User $user
     * @param Channel $channel
     * @param Channel_payment $Channel_payment
     * @param Request $request
     * @param User_rates $user_rates
     * @param array $account_array
     * @return mixed
     */
    public function add(User $user, Channel $channel, Channel_payment $Channel_payment, Request $request, User_rates $user_rates, array $account_array)
    {
        // 订单收益计算
        $order_amount_array = $this->orderRateService->orderFee($user, $Channel_payment, $user_rates, $request->amount);
        $extend = array(
            'tm'        => $request->order_time ? $request->order_time : date('Y-m-d H:i:s',time()),
            'attach'    => $request->attach ? $request->attach : '',
            'cuid'      => $request->cuid ? $request->cuid : '',
        );

        $param = array(
            'user_id'       => $user->id,
            'merchant'      => $user->merchant,
            'agent_id'      => $user->parentId,
            'channel_id'    => $channel->id,
            'channelName'   => $channel->channelName,
            'channel_payment_id'    => $Channel_payment->id,
            'paymentName'           => $Channel_payment->paymentName,
            'account'       => $account_array['account'] ?: $account_array['account'] ,
            'orderNo'       => getOrderId(),
            'underOrderNo'  => $request->order_no,
            'amount'        => $request->amount,
            'orderRate'     => $order_amount_array['orderFee'],
            'sysAmount'     => $order_amount_array['sysAmount'],
            'agentAmount'   => $order_amount_array['agentAmount'],
            'userAmount'    => $order_amount_array['userAmount'],
            'notifyUrl'     => $request->notify_rul,
            'successUrl'    => $request->return_url,
            'extend'        => json_encode($extend),
            'status'        => 0
        );
        return $this->ordersRepository->add($param);
    }

    /**
     * 订单金额
     * @return int
     */
    public function amountSum($data)
    {
          $data=$this->ordersRepository->Summing($data);
          $sum=0;
          foreach ($data as $v){
              $sum=$sum+$v['amount'];
          }
          return $sum;
    }

    /**
     * 手续费
     * @return int
     */
    public function orderRateSum($data)
    {
        $data=$this->ordersRepository->Summing($data);
        $sum=0;
        foreach ($data as $v){
            $sum=$sum+$v['orderRate'];
        }
        return $sum;
    }

    /**
     * 订单总数
     * @return int
     */
    public function orderSum($data)
    {
        $data=$this->ordersRepository->Summing($data);
        $sum=0;
        foreach ($data as $v){
            $sum=$sum+1;
        }
        return $sum;
    }

    /**
     * 订单查询，带分页
     * @param array $data
     * @param int $page
     * @return mixed
     */
    public function searchPage(array $data, int $page)
    {
        return $this->ordersRepository->searchPage($data, $page);
    }


    /**
     * 根据id获取
     * @param int $id
     * @return array
     */
    public function findId(int $id)
    {
        $channels = $this->ordersRepository->findId($id);
        return $channels->toArray();
    }

    /**
     * 获取所有，分页
     * @param int $page
     * @return mixed
     */
    public function getAllPage($data,int $page)
    {
        return $this->ordersRepository->getAllPage($data,$page);
    }

    /**
     * 更新
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, array $data)
    {
        return $this->ordersRepository->update($id, $data);
    }

    /**
     * 状态变更
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function updateStatus(int $id, array $data){

        return $this->ordersRepository->update($id, $data);
    }

    /**
     * 伪删除
     * @param int $id
     * @return mixed
     */
    public function destroy(int $id)
    {
        return $this->ordersRepository->update($id,['status'=>2]);
    }
}