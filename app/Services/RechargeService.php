<?php

namespace App\Services;

use App\Repositories\RechargeRepository;
use App\Exceptions\CustomServiceException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class RechargeService
{
    protected $rechargeRepository;
    protected $systemsService;

    public function __construct(RechargeRepository $rechargeRepository, SystemsService $systemsService)
    {
        $this->rechargeRepository = $rechargeRepository;
        $this->systemsService = $systemsService;
    }

    protected function phoneStatusCheck()
    {
        if($phone_id = $this->systemsService->findKey('recharge_ali_phone')){
            Redis::select(1);
            if(!Redis::exists($phone_id.'alipay')) throw new CustomServiceException('设备异常，请联系我们');
            $get_account = Redis::hGetAll($phone_id.'alipay');

            if( (time() > (strtotime($get_account['update'])+50) && $get_account['status'] == 1 ) )
            {
                throw new CustomServiceException('设备异常，请联系我们');
            }

            // 验证手机和支付宝id是否一致
            if($get_account['userid'] != $this->systemsService->findKey('recharge_ali_uid') )
            {
                throw new CustomServiceException('支付宝ID异常，请联系我们');
            }

            return true;

        }else{
            throw new CustomServiceException('未配置收款账号');
        }
    }

    /**
     * 添加
     * @param float $money
     * @return mixed
     */
    public function add(float $money)
    {
        if( !$this->phoneStatusCheck())throw new CustomServiceException('设备异常，请联系我们');

        $data = [
            'user_id'           => Auth::user()->id,
            'recharge_amount'   => $money,
            'merchant'          => Auth::user()->merchant,
            'actual_amount'     => $money,
            'orderNo'           => 'C'.getOrderId(),
            'orderMk'           => '',
            'pay_status'        => 0,
        ];
        if(!$result = $this->rechargeRepository->add($data))throw new CustomServiceException('充值订单添加失败');

        $ali_uid = $this->systemsService->findKey('recharge_ali_uid');
        $name    = $this->systemsService->findKey('recharge_ali_name');
        $order_date = array(
            'amount'  => $result->actual_amount,
            'meme'    => $result->orderNo,
            'userID'  => $ali_uid,
            'status'  => 0,
            'type'    => 'alipay',
            'sweep_num'  => 0
        );

        Redis::hmset($result->orderNo, $order_date);
        Redis::expire($result->orderNo,1800);

        $data = [
            'type'    => 'alipay',
            'username'=> $name,
            'money'   => sprintf('%0.2f',$result->actual_amount),
            'orderNo' => $result->orderNo,
            'payurl'  => 'alipays://platformapi/startapp?appId=20000123&actionType=scan&biz_data={"s": "money","u": "'.$ali_uid.'","a": "'.$result->amount.'","m": "'.$result->orderNo.'"}',
            'h5url'   => 'alipays://platformapi/startapp?appId=20000067&url='. 'http://'.$_SERVER['HTTP_HOST'].'/pay/h5pay/'. $result->orderNo,
        ];

        return $data;
    }

    public function findUserIdAndOrderNo(string $uid, string $order_no)
    {
        return $this->rechargeRepository->findUserIdAndOrderNo($uid,$order_no);
    }

    public function findUserIdAll(int $uid, int $page)
    {
        return $this->rechargeRepository->findUserIdAll($uid, $page);
    }

    /**
     *
     * @param int $page
     * @return mixed
     */
    public function getAllPage(int $page)
    {
        return $this->rechargeRepository->getAllPage($page);
    }

    public function findOrderNo(string $order_no)
    {
        return $this->rechargeRepository->findOrderNo($order_no);
    }

    public function update(int $id, array $data)
    {
        return $this->rechargeRepository->update($id, $data);
    }
}