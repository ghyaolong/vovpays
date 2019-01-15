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
use App\Services\UserPermissionServer;
use Mockery\Exception;


class WithdrawsService
{
    protected $withdrawsRepository;
    protected $bankCardRepository;

    public function __construct(WithdrawsRepository $withdrawsRepository, BankCardRepository $bankCardRepository)
    {
        $this->withdrawsRepository = $withdrawsRepository;
        $this->bankCardRepository = $bankCardRepository;
    }


    public function add(array $data)
    {
        //权限验证
        UserPermissionServer::checkPermission($data['auth_code']);
        //验证账户余额
        $this->accountVerify($data);
//        //获取提款规则信息
//        $this->getWithdrawRule($data);
        try {
            DB::beginTransaction();
            //账户余额更新
            $this->updateAccount($data);
//          //资金变动记录
//          $this->addMoneyDetail($data);
            //添加提款记录
            $this->addWithdrawInfo($data);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return false;
        }
        return true;

    }

    protected function updateAccount($data)
    {
        //提现手续费
        $data['withdrawRate'] = 5;
        //到账金额
        $data['toAmount'] = $data['withdrawAmount'] - $data['withdrawRate'];
        return $data;
    }

    protected function addMoneyDetail($data)
    {
        return true;
    }

    /**获取提款规则信息
     * @param $data
     * @return array
     */
    protected function getWithdrawRule($data)
    {

        $withdrawRule = [];
        return $withdrawRule;
    }

    /**验证账户余额
     * @return bool
     */
    protected function accountVerify($data)
    {
        return true;
    }

    /**添加提款记录
     * @param $data
     * @return mixed
     */

    protected function addWithdrawInfo($data)
    {

        // 去掉无用数据
        $data = array_except($data, ['_token', 'payPassword']);

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
        $data['user_id'] = Auth::user()->id;


        return $this->withdrawsRepository->add($data);
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