<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/11/17
 * Time: 13:54
 */

namespace App\Services;


use App\Repositories\BankCardRepository;

class BankCardService
{
    protected $bankCardRepository;

    public function __construct(BankCardRepository $bankCardRepository)
    {
        $this->bankCardRepository=$bankCardRepository;
    }

    /**
     * 添加
     * @param array $data
     * @return mixed
     */

    public function add(array $data)
    {
        return $this->bankCardRepository->add($data);
    }
}