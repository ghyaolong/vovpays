<?php

namespace App\Services;

use App\Models\User;
use App\Models\Channel;
use App\Models\Channel_payment;
use App\Repositories\OrdersRepository;
use Illuminate\Http\Request;

class OrdersService
{
    protected $ordersRepository;

    public function __construct(OrdersRepository $ordersRepository)
    {
        $this->ordersRepository = $ordersRepository;
    }

    /**
     * @param User $user
     * @param Channel $channel
     * @param Channel_payment $Channel_payment
     * @param Request $request
     * @param array $order_amount_array
     * @param array $account_array
     * @return mixed
     */
    public function add(User $user, Channel $channel, Channel_payment $Channel_payment, Request $request, array $order_amount_array, array $account_array)
    {
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
    public function getAllPage(int $page)
    {
        return $this->ordersRepository->getAllPage($page);
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