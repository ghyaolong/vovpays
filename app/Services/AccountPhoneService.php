<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/12/21
 * Time: 17:12
 */

namespace App\Services;


use App\Repositories\AccountPhoneRepository;

class AccountPhoneService
{
    protected $accountPhoneRepository;

    /**
     * AccountPhoneService constructor.
     * @param AccountPhoneRepository $accountPhoneRepository
     */
    public function __construct(AccountPhoneRepository $accountPhoneRepository)
    {
        $this->accountPhoneRepository = $accountPhoneRepository;
    }


    /**
     * 带分页查询
     * @param array $data
     * @param int $page
     * @return mixed
     */
    public function getAllPage(array $data, int $page)
    {
        $sql = ' 1=1 ';
        $where = [];

        if (isset($data['account']) && $data['account']) {
            $sql .= 'and account = ?';
            $where['account'] = $data['account'];
        }
        if (isset($data['accountType']) && $data['accountType']) {
            if ($data['accountType'] == 'alipay') {
                $data['accountType'] = '支付宝';
            } elseif ($data['accountType'] == 'wechat') {
                $data['accountType'] = '微信';
            }
            $sql .= ' and accountType = ?';
            $where['accountType'] = $data['accountType'];
        }

        return $this->accountPhoneRepository->searchPage($sql, $where, $page);
    }

    /**
     * 添加
     * @param array $data
     * @return mixed
     */
    public function add(array $data)
    {
        $data = array_except($data, ['_token']);

        if (isset($data['alipayusername']) && isset($data['alipayuserid'])) {
            $data['accountType'] = "支付宝";
            $data['channel_payment_id'] = 1;
        } else {
            $data['accountType'] = "微信";
            $data['channel_payment_id'] = 2;
        }

        return $this->accountPhoneRepository->add($data);
    }

    public function updata(int $id, array $data)
    {
        $data = array_except($data, ['_token']);
        return $this->accountPhoneRepository->update($id, $data);
    }

    /**
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function updateStatus(int $id, array $data)
    {
        return $this->accountPhoneRepository->update($id, $data);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function findId(int $id)
    {
        return $this->accountPhoneRepository->findId($id);
    }

    public function del(int $id)
    {
        return $this->accountPhoneRepository->del($id);
    }


    public function searchAccountAll( string $type, int $status){
        if($type == 'alipay'){
            $type = '支付宝';
        }elseif($type == 'wechat'){
            $type = '微信';
        }
        return $this->accountPhoneRepository->searchAccountAll($type, $status);
    }
}