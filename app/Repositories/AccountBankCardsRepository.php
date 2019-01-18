<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/1/15
 * Time: 17:35
 */

namespace App\Repositories;


use App\Models\Account_bank_cards;

class AccountBankCardsRepository
{
    protected $account_bank_cards;

    public function __construct(Account_bank_cards $account_bank_cards)
    {
        $this->account_bank_cards = $account_bank_cards;
    }


    /**
     * @param array $data
     * @param int $page
     * @return mixed
     */
    public function searchPage(array $data, int $page)
    {
        $sql = ' 1=1 ';
        $where = [];

        if (isset($data['bank_account']) && $data['bank_account']) {
            $sql .= 'and bank_account = ?';
            $where['bank_account'] = $data['bank_account'];
        }
        if (isset($data['user_id']) && $data['user_id']) {
            $sql .= ' and user_id = ?';
            $where['user_id'] = $data['user_id'];
        }

        return $this->account_bank_cards->whereRaw($sql, $where)->paginate($page);

    }

    /**
     * @param array $data
     * @return bool
     */
    public function add(array $data)
    {
        $string = strtolower(str_random(32));

        $result = $this->account_bank_cards->where('signKey', '=', $string)->first();
        if (!isset($result)) {
            $data['signKey'] = $string;
        } else {
            return false;
        }
        return $this->account_bank_cards->create($data);
    }

    /**
     * @param int $id
     * @param int $uid
     * @param array $data
     * @return mixed
     */
    public function update(int $id, int $uid, array $data)
    {
        return $this->account_bank_cards->whereId($id)->whereUserId($uid)->update($data);
    }


    /**
     * @param int $id
     * @param int $uid
     * @return mixed
     */
    public function findIdAndUserId(int $id, int $uid)
    {
        return $this->account_bank_cards->whereId($id)->whereUserId($uid)->first();
    }

    /**
     * @param int $id
     * @param int $uid
     * @return mixed
     */
    public function del(int $id,int $uid)
    {
        return $this->account_bank_cards->whereId($id)->whereUserId($uid)->delete();
    }

    /**
     * @param int $uid
     * @param int $status
     * @return mixed
     */
    public function getStatusAndUserId(int $uid, int $status)
    {
        return $this->account_bank_cards->whereStatus($status)->whereUserId($uid)->get();
    }

    /**
     * @param int $third
     * @param int $status
     * @return mixed
     */
    public function getStatusAndThird(int $status, int $third )
    {
        return $this->account_bank_cards->whereStatus($status)->whereThird($third)->get();
    }

    /**
     * 检测唯一
     * @param string $field
     * @param string $value
     * @param int|null $id
     * @return mixed
     */
    public function searchCheck(string $field, string $value, int $id = null)
    {
        if ($id) {
            if ($field == 'cardNo') {
                $sql = "id <> $id and cardNo = ?";
                $where['cardNo'] = $value;
            }
        } else {
            if ($field == 'cardNo') {
                $sql = " cardNo = ?";
                $where['cardNo'] = $value;

            }
        }
        return $this->account_bank_cards->whereRaw($sql, $where)->first();
    }


}