<?php

namespace App\Services;

use App\Models\User;
use App\Models\Channel;
use App\Models\Channel_payment;
use App\Models\User_rates;
use App\Repositories\OrdersRepository;
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
        if( $request->pay_code == "alipay_bank" )
        {
            $amount = $account_array['realPrice'];
        }else{
            $amount = $request->amount;
        }
        // 订单收益计算
        $order_amount_array = $this->orderRateService->orderFee($user, $Channel_payment, $user_rates, $amount);
        $extend = array(
            'tm'        => $request->order_time ? $request->order_time : date('Y-m-d H:i:s',time()),
            'attach'    => $request->attach ? $request->attach : '',
            'cuid'      => $request->cuid ? $request->cuid : '',
            'realPrice' => $request->amount,
        );

        $param = array(
            'user_id'       => $user->id,
            'merchant'      => $user->merchant,
            'agent_id'      => $user->parentId,
            'channel_id'    => $channel->id,
            'channelName'   => $channel->channelName,
            'channel_payment_id'    => $Channel_payment->id,
            'paymentName'           => $Channel_payment->paymentName,
            'account'       => $account_array['account'] ?: $account_array['account'],
            'phone_id'      => $account_array['phone_id'],
            'orderNo'       => getOrderId(),
            'underOrderNo'  => $request->order_no,
            'amount'        => $amount,
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
     * 订单详情统计
     * @param array $data
     * @param string $type 默认只统计成功订单
     * @return array
     */
    public function orderInfoSum(array $data, string $type ='success')
    {
        return $this->ordersRepository->Summing($data,$type);
    }

    /**
     * 根据平台订单查询
     * @param string $order_no
     * @return mixed
     */
    public function findOrderNo(string $order_no)
    {
        return $this->ordersRepository->findOrderNo($order_no);
    }

    /**
     * 根据商户订单查询
     * @param string $order_no
     * @return mixed
     */
    public function findUnderOrderNo(string $order_no)
    {
        return $this->ordersRepository->findUnderOrderNo($order_no);
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
     * @param string $type
     * @return mixed | array
     */
    public function findId(int $id, $type ='array')
    {
        $orders = $this->ordersRepository->findId($id);
        if($type == 'array')
        {
            return $orders->toArray();
        }else{
            return $orders;
        }

    }

    /**
     * 获取所有，分页
     * @param array $data
     * @param int $page
     * @return mixed
     */
    public function getAllPage(array $data,int $page)
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