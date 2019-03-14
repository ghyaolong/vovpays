<?php

namespace App\Services;

use App\Repositories\RechargeRepository;
use App\Exceptions\CustomServiceException;
use App\Repositories\StatisticalRepository;
use App\Repositories\UsersRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\DB;

class RechargeService
{
    protected $rechargeRepository;
    protected $systemsService;
    protected $usersRepository;

    public function __construct(RechargeRepository $rechargeRepository, SystemsService $systemsService, UsersRepository $usersRepository)
    {
        $this->rechargeRepository = $rechargeRepository;
        $this->systemsService = $systemsService;
        $this->usersRepository = $usersRepository;
    }

    protected function phoneStatusCheck()
    {
        if ($phone_id = $this->systemsService->findKey('recharge_ali_phone')) {
            Redis::select(1);
            if (!Redis::exists($phone_id . 'alipay')) throw new CustomServiceException('设备异常，请联系我们');
            $get_account = Redis::hGetAll($phone_id . 'alipay');

            if ((time() > (strtotime($get_account['update']) + 50) && $get_account['status'] == 1)) {
                throw new CustomServiceException('设备异常，请联系我们');
            }

            // 验证手机和支付宝id是否一致
            if ($get_account['userid'] != $this->systemsService->findKey('recharge_ali_uid')) {
                throw new CustomServiceException('支付宝ID异常，请联系我们');
            }

            return true;

        } else {
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
        if (!$this->phoneStatusCheck()) throw new CustomServiceException('设备异常，请联系我们');

        $data = [
            'user_id' => Auth::user()->id,
            'recharge_amount' => $money,
            'merchant' => Auth::user()->merchant,
            'actual_amount' => $money,
            'orderNo' => 'C' . getOrderId(),
            'orderMk' => '',
            'pay_status' => 0,
        ];
        if (!$result = $this->rechargeRepository->add($data)) throw new CustomServiceException('充值订单添加失败');

        $ali_uid = $this->systemsService->findKey('recharge_ali_uid');
        $name = $this->systemsService->findKey('recharge_ali_name');
        $order_date = array(
            'amount' => $result->actual_amount,
            'meme' => $result->orderNo,
            'userID' => $ali_uid,
            'status' => 0,
            'type' => 'alipay',
            'sweep_num' => 0
        );

        Redis::hmset($result->orderNo, $order_date);
        Redis::expire($result->orderNo, 1800);

        $data = [
            'type' => 'alipay',
            'username' => $name,
            'money' => sprintf('%0.2f', $result->actual_amount),
            'orderNo' => $result->orderNo,
            'payurl' => 'alipays://platformapi/startapp?appId=20000123&actionType=scan&biz_data={"s": "money","u": "' . $ali_uid . '","a": "' . $result->amount . '","m": "' . $result->orderNo . '"}',
            'h5url' => 'alipays://platformapi/startapp?appId=20000067&url=' . 'http://' . $_SERVER['HTTP_HOST'] . '/pay/h5pay/' . $result->orderNo,
        ];

        return $data;
    }

    public function findUserIdAndOrderNo(string $uid, string $order_no)
    {
        return $this->rechargeRepository->findUserIdAndOrderNo($uid, $order_no);
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
    public function getAllPage(array $data, int $page = 15)
    {
        $sql = "1=1 ";
        $where = [];


        if (isset($data['created_at'])) {
            $time = explode(" - ", $data['created_at']);
            if (isset($time[0]) && $time[0]) {
                $sql .= ' and created_at >= ?';
                $where['created_at'] = $time[0];
            }
            if (isset($time[1]) && $time[1]) {
                $sql .= ' and created_at <= ?';
                $where['updated_at'] = $time[1];
            }
        }
        if (isset($data['pay_status']) && $data['pay_status'] != -1) {
            $sql .= " and pay_status = ? ";
            $where['pay_status'] = $data['pay_status'];
        }
        if (isset($data['merchant']) ) {
            $sql .= " and merchant = ? ";
            $where['merchant'] = $data['merchant'];
        }
        if (isset($data['orderNo'])) {
            $sql .= " and orderNo = ? ";
            $where['orderNo'] = $data['orderNo'];
        }


        return $this->rechargeRepository->getAllPage($sql, $where, $page);
    }

    public function findOrderNo(string $order_no)
    {
        return $this->rechargeRepository->findOrderNo($order_no);
    }

    public function update(int $id, array $data)
    {
        return $this->rechargeRepository->update($id, $data);
    }

    //充值补单
    public function RechargeSuccess(int $id)
    {
        $recharge = $this->rechargeRepository->findId($id);

        DB::connection('mysql')->transaction(function () use ($recharge) {

            $result = $this->rechargeRepository->update($recharge->id, ['pay_status' => 1,'orderMk'=>'总后台手动补单']);
            $statisticalrepository = app(StatisticalRepository::class);
            // 商户充值金额增加
            $result && $result = $statisticalrepository->updateUseridBalanceIncrement($recharge->user_id, $recharge->actual_amount);

            if (!$result) {
                throw new CustomServiceException('系统故障,修改状态失败');
            }
        });
        return true;
    }
}