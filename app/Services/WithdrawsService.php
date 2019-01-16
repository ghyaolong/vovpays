<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/11/20
 * Time: 10:12
 */

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Repositories\WithdrawsRepository;
use App\Repositories\BankCardRepository;
use App\Repositories\StatisticalRepository;
use App\Exceptions\CustomServiceException;
use App\Repositories\SystemsRepository;
use Illuminate\Support\Facades\DB;


class WithdrawsService
{
    protected $withdrawsRepository;
    protected $bankCardRepository;
    protected $statisticalRepository;

    public function __construct(WithdrawsRepository $withdrawsRepository, BankCardRepository $bankCardRepository, StatisticalRepository $statisticalRepository)
    {
        $this->withdrawsRepository = $withdrawsRepository;
        $this->bankCardRepository = $bankCardRepository;
        $this->statisticalRepository = $statisticalRepository;

    }


    public function add(array $data)
    {
        try {
            $data['user_id'] = Auth::user()->id;

            //权限验证
            UserPermissionServer::checkPermission($data['auth_code']);

            //获取提款规则信息
            $withdrawRule = $this->getWithdrawRule($data);
            //验证账户余额
            $this->accountVerify($data, $withdrawRule);
            //手续费计算
            $this->caculateRate($data, $withdrawRule);

            //添加提款记录
            $data = $this->buildWithdrawInfo($data);


            DB::connection('mysql')->transaction(function () use ($data) {
                //账户余额更新

                $this->statisticalRepository->updateUseridBalanceDecrement($data['user_id'], $data['withdrawAmount']);
                //资金变动记录
//              $this->addMoneyDetail($data);
                $this->withdrawsRepository->add($data);

//                DB::connection('mysql')->table('statisticals')->whereUserId($data['user_id'])->decrement('balance', $data['withdrawAmount']);
//                DB::connection('mysql')->table('withdraws')->insert($data);

            }, 3);

            return ['status' => true];

        } catch (CustomServiceException $customexception) {
            $msg = $customexception->getMessage();
            return ['status' => false, 'msg' => $msg];
        } catch (\Exception $exception) {

            $msg = $exception->getMessage();
            return ['status' => false, 'msg' => '系统错误:' . $msg];
        }


    }

    /**
     * @param $data
     * @return bool
     */
    protected function addMoneyDetail($data)
    {
        return true;
    }

    /**获取提款规则信息
     * @param $data
     * @return array
     */
    public function getWithdrawRule()
    {
        $withdrawRule = [];
        $withdrawRule['withdraw_downline'] = SystemsRepository::findKey('withdraw_downline');
        $withdrawRule['withdraw_fee_type'] = SystemsRepository::findKey('withdraw_fee_type');
        $withdrawRule['withdraw_rate'] = SystemsRepository::findKey('withdraw_rate');
        return $withdrawRule;
    }

    /**金额验证
     * @return bool
     */
    protected function accountVerify($data, $withdrawRule)
    {
        if ($withdrawRule['withdraw_downline'] > $data['withdrawAmount']) {
            throw   new CustomServiceException('提现金额不能少于' . $withdrawRule['withdraw_downline'] . '元');
        }

        $useraccount = $this->statisticalRepository->findUserId($data['user_id']);

        if ($useraccount['balance'] < $data['withdrawAmount']) {
            throw   new CustomServiceException('提现金额超过账户可提现金额');
        }

    }

    /**计算提款手续费
     * @param $data
     * @param $withdrawRule
     */
    protected function caculateRate(&$data, $withdrawRule)
    {

        switch ($withdrawRule['withdraw_fee_type']) {
            case 'RATE':
                $data['withdrawRate'] = bcmul($data['withdrawAmount'], bcdiv($withdrawRule['withdraw_rate'], 100, 2), 2);
                $data['toAmount'] = bcsub($data['withdrawAmount'], $data['withdrawRate'], 2);
                break;
            case 'FIX':
                $data['withdrawRate'] = $withdrawRule['withdraw_rate'];
                $data['toAmount'] = bcsub($data['withdrawAmount'], $data['withdrawRate'], 2);
                break;
            default :
                throw new  CustomServiceException('不存在的提款收费类型:' . $withdrawRule['withdraw_fee_type'] . ',请联系平台管理员!');
        }
    }

    /**添加提款记录
     * @param $data
     * @return mixed
     */

    protected function buildWithdrawInfo($data)
    {

        // 去掉无用数据
        $data = array_except($data, ['_token', 'auth_code']);

        //银行卡信息
        $bankCard = $this->bankCardRepository->findId($data['bank_id']);
        unset($data['bank_id']);
        //银行信息

        $bankInfo = $bankCard->Bank->toArray();

        $data['accountName'] = $bankCard['accountName'];
        $data['branchName'] = $bankCard['branchName'];
        $data['bankCardNo'] = $bankCard['bankCardNo'];

        $data['bankName'] = $bankInfo['bankName'];
        $data['bankCode'] = $bankInfo['code'];
        $data['orderId'] = static::buildWithdrawOrderid();

        return $data;

    }


    /**
     * 搜索分页
     * @param array $data
     * @param int $page
     * @return mixed
     */
//    public function searchPage(array $data, int $page)
//    {
//        $sql = '1=1';
//        $time=explode(" - ",$data['orderTime']);
//
//        if (isset($data['user_id']) && $data['user_id']) {
//            $sql .= ' and user_id = ?';
//            $where['user_id'] = $data['user_id'];
//        }
//
//        if (isset($time[0]) && $time[0]) {
//            $sql .= ' and created_at >= ?';
//            $where['created_at'] = $time[0];
//        }
//
//        if (isset($time[1]) && $time[1]) {
//            $sql .= ' and created_at <= ?';
//            $where['updated_at'] = $time[1];
//        }
//
//        if (isset($data['status']) && $data['status'] != '-1') {
//            $sql .= ' and status = ?';
//            $where['status'] = $data['status'];
//        }
//        return $this->withdrawsService->searchPage($sql, $where, $page);
//    }

    /**
     * 结算记录
     * @param int $id
     * @param int $page
     * @return mixed
     */
    public function getAllPage(int $page)
    {
        return $this->withdrawsRepository->searchPage($page);
    }

    /**生成提款订单号
     * @return string
     */
    static private function buildWithdrawOrderid()
    {

        return 'W' . date('ymdhis') . mt_rand(10000, 99999);
    }
}