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
        return $this->accountPhoneRepository->searchPage($data, $page);
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

    /**
     * 根据用户id和表示id修改
     * @param int $id
     * @param int $uid
     * @param array $data
     * @return mixed
     */
    public function update(int $id, int $uid, array $data)
    {
        $data = array_except($data, ['_token']);
        return $this->accountPhoneRepository->update($id, $uid, $data);
    }

    /**
     * @param int $id
     * @param int $uid
     * @return mixed
     */
    public function findIdAndUserId(int $id, int $uid)
    {
        return $this->accountPhoneRepository->findIdAndUserId($id,$uid);
    }

    /**
     * @param int $id
     * @param int $uid
     * @return mixed
     */
    public function del(int $id, int $uid)
    {
        return $this->accountPhoneRepository->del($id,$uid);
    }

    /**
     * @param string $type
     * @param int $uid
     * @param int $status
     * @return mixed
     */
    public function getStatusAndAccountType( string $type,int $uid, int $status){
        return $this->accountPhoneRepository->getStatusAndAccountType($type, $uid, $status);
    }

    /**
     * @param string $phoneid
     * @param int $status
     * @param int $uid
     * @return mixed
     */
    public function getPhoneidAndStatusAndUserid(string $phoneid, int $status, int $uid )
    {
        return $this->accountPhoneRepository->getPhoneidAndStatusAndUserid($phoneid, $status, $uid);
    }
}