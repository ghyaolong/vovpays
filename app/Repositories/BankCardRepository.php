<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/11/17
 * Time: 13:56
 */

namespace App\Repositories;


use App\Models\Bank_card;

class BankCardRepository
{
    protected $bankCard;

    public function __construct(Bank_card $bank_card)
    {
        $this->bankCard=$bank_card;
    }

    /**
     * 添加
     * @param array $data
     * @return mixed
     */

    public function add(array $data)
    {
        $this->bankCard->create($data);
    }

}