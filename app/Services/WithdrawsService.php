<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/11/20
 * Time: 10:12
 */

namespace App\Services;


use App\Repositories\WithdrawsRepository;

class WithdrawsService
{
    protected $withdrawsService;
    protected $userRateService;

    public function __construct(WithdrawsRepository $withdrawsRepository, UserRateService $userRateService)
    {
        $this->withdrawsService = $withdrawsRepository;
        $this->userRateService = $userRateService;
    }


    public function add(array $data)
    {
        // 去掉无用数据
        $data = array_except($data, ['_token', 'bankCardNo', 'accountName', 'payPassword']);

        //获取费率
        $userRate = $this->userRateService->getFindUidPayId($data['user_id'], 1);
        $rate = $userRate['rate'];
        //提现手续费
        $data['withdrawRate']=$data['withdrawAmount']*$rate;
        //到账金额
        $data['toAmount']=$data['withdrawAmount']-$data['withdrawRate'];

        return $this->withdrawsService->add($data);
    }

    /**
     * 结算记录
     * @param int $id
     * @param int $page
     * @return mixed
     */
    public function getAllPage(int $id, int $page)
    {
        $sql = '1=1';
        $where['user_id'] = $id;
        return $this->withdrawsService->searchPage($sql, $where, $page);
    }
}