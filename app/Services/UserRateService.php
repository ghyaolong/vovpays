<?php

namespace App\Services;

use App\Repositories\UserRateRepository;
use App\Exceptions\CustomServiceException;
use App\Services\ChannelPaymentsService;

class UserRateService
{
    protected $userRateRepository;
    protected $channelPaymentsService;
    protected $userService;
    protected $channelService;

    public function __construct(UserRateRepository $userRateRepository, ChannelPaymentsService $channelPaymentsService,
                                UserService $userService, ChannelService $channelService)
    {
        $this->userRateRepository     = $userRateRepository;
        $this->channelPaymentsService = $channelPaymentsService;
        $this->userService      = $userService;
        $this->channelService   = $channelService;
    }

    /**
     * 获取所有开启的支付方式并根据用户id组装数据
     * @param string $user_id
     * @return array
     */
    public function getFindUidRate(string $user_id)
    {

        $user = $this->userService->findId($user_id);

        // 会员不存在代理的时候，获取所有支付产品，存在代理获取代理的支付产品
        if($user->parentId == 0)
        {
            $sql = 'user_id=?';
            $where['user_id'] = $user_id;
            $user_rate_list = $this->userRateRepository->search($sql, $where);
            // 以支付方式id为key 转为数组
            $user_rate_array = $user_rate_list->keyBy('channel_payment_id')->toArray();

            // 获取所有已启用支付方式
            $sql = ' and status=?';
            $channelWhere['status'] = 1;
            $channelPayment_list = $this->channelPaymentsService->getAll($sql,$channelWhere);
            $channelPayment_array = $channelPayment_list->keyBy('id')->toArray();

            foreach ($channelPayment_array as $key=>$item)
            {
                $channelPayment_array[$key]['status'] = @$user_rate_array[$key]['status'] ?: 0 ;
                $channelPayment_array[$key]['rate'] = @floatval($user_rate_array[$key]['rate']) ?: 0 ;
            }

        }else{
            // 获取代理开启的支付产品
            $sql = 'user_id=?';
            $where['user_id'] = $user->parentId;
            $agent_rate_list = $this->userRateRepository->search($sql, $where);
            // 以支付方式id为key 转为数组
            $agent_rate_array = $agent_rate_list->keyBy('channel_payment_id')->toArray();

            // 获取所有已启用支付方式
            $sql = ' and status=?';
            $channelWhere['status'] = 1;
            $channelPayment_list = $this->channelPaymentsService->getAll($sql,$channelWhere);
            $channelPayment_array = $channelPayment_list->keyBy('id')->toArray();

            // unset 代理不存在的支付方式
            foreach ($channelPayment_array as $key=>$item)
            {
                if( !isset($agent_rate_array[$key]))
                {
                    unset($channelPayment_array[$key]);
                }else{
                    $channelPayment_array[$key]['status'] = @$agent_rate_array[$key]['status'] ?: 0 ;
                    $channelPayment_array[$key]['rate'] = @floatval($agent_rate_array[$key]['rate']) ?: 0 ;
                }
            }

            // 获取用户自身存在的支付方式
            $sql = 'user_id=?';
            $where['user_id'] = $user_id;
            $user_rate_list = $this->userRateRepository->search($sql, $where);
            // 以支付方式id为key 转为数组
            $user_rate_array = $user_rate_list->keyBy('channel_payment_id')->toArray();

            // 替换值为商户的值
            foreach ($channelPayment_array as $key=>$value)
            {
                $channelPayment_array[$key]['status'] = @$user_rate_array[$key]['status'] ?: 0 ;
                $channelPayment_array[$key]['rate'] = @floatval($user_rate_array[$key]['rate']) ?: 0 ;
            }
        }
        return $channelPayment_array;
    }

    /**
     * 修改状态
     * @param int $user_id
     * @param int $pay_id
     * @param string $status
     * @param int $channelId
     * @return mixed
     */
    public function saveStatus(int $user_id, int $pay_id, string $status, int $channelId)
    {
        $sql = 'user_id = ? and channel_payment_id = ?';
        $where['user_id'] = $user_id;
        $where['channel_payment_id'] = $pay_id;
        $userRate = $this->userRateRepository->searchOne($sql, $where);
        if($userRate)
        {
            $userRate->status = $status == 'true' ? '1' : '0';
            if($userRate->save())
            {
                return true;
            }else{
                return false;
            }
        }else{
            $data['user_id']            = $user_id;
            $data['channel_id']         = $channelId;
            $data['channel_payment_id'] = $pay_id;
            $data['status']             = 'true' ? '1' : '0';
            if($this->userRateRepository->add($data)){
                return true;
            }else{
                return false;
            }
        }
    }

    /**
     * 根据用户id和支付id获取费率
     * @param int $user_id
     * @param int $pay_id
     * @return mixed
     */
    public function getFindUidPayId(int $user_id, int $pay_id)
    {
        $sql = 'user_id = ? and channel_payment_id = ?';
        $where['user_id'] = $user_id;
        $where['channel_payment_id'] = $pay_id;
        $userRate = $this->userRateRepository->searchOne($sql, $where);
        return $userRate;
    }

    /**
     * 根据用户id和支付id获取商户启用的支付方式
     * @param int $user_id
     * @param int $pay_id
     * @return mixed
     */
    public function getFindUidPayIdStatus(int $user_id, int $pay_id)
    {
        $sql = 'user_id = ? and channel_payment_id = ? and status=1';
        $where['user_id'] = $user_id;
        $where['channel_payment_id'] = $pay_id;
        $userRate = $this->userRateRepository->searchOne($sql, $where);
        return $userRate;
    }

    /**
     * 会员费率增加和编辑
     * @param int $user_id
     * @param int $channelId
     * @param float $rate
     * @param int $pay_id
     * @param int $status
     * @return mixed
     */
    public function userRateStore(int $user_id, int $channelId, float $rate, int $pay_id, int $status)
    {
        $user = $this->userService->findId($user_id);
        $channelPayment = $this->channelPaymentsService->findId($pay_id);

        if($rate > $channelPayment['runRate'] )
        {
            throw new CustomServiceException('会员费率不能大于运营费率');
        }

        // 用户不存在代理的时候
        if($user->parentId == 0)
        {
            if( $rate != 0 && $rate < $channelPayment['costRate'] )
            {
                throw new CustomServiceException('会员费率不能小于成本费率');
            }
        }else{
            $sql = 'user_id = ? and channel_payment_id = ? ';
            $where['user_id'] = $user->parentId;
            $where['channel_payment_id'] = $pay_id;
            $agentRate = $this->userRateRepository->searchOne($sql, $where);
            if(!$agentRate)
            {
                throw new CustomServiceException('该用户的上级代理未开通该支付产品！');
            }

            if( $rate != 0 && $rate < $agentRate->rate )
            {
                throw new CustomServiceException('会员费率不能小于上级代理的费率');
            }
        }

        $sql2 = 'user_id = ? and channel_payment_id = ?';
        $where2['user_id'] = $user_id;
        $where2['channel_payment_id'] = $pay_id;
        $userRate = $this->userRateRepository->searchOne($sql2, $where2);
        if($userRate)
        {
            $userRate->user_id      = $user_id;
            $userRate->channel_id   = $channelId;
            $userRate->rate         = $rate;
            $userRate->status       = $status;
            $userRate->channel_payment_id = $pay_id;
            $result = $userRate->save();
        }else{
            $data['user_id']    = $user_id;
            $data['channel_id'] = $channelId;
            $data['rate']       = $rate;
            $data['status']     = $status;
            $data['channel_payment_id'] = $pay_id;
            $result = $this->userRateRepository->add($data);
        }
        return $result;
    }
}