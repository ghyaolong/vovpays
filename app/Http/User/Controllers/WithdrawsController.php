<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/11/20
 * Time: 9:55
 */

namespace App\Http\User\Controllers;


use App\Services\WithdrawsService;

class WithdrawsController extends Controller
{
    protected $withdrawsService;

    /**
     * WithdrawsController constructor.
     * @param WithdrawsService $withdrawsService
     */
    public function __construct(WithdrawsService $withdrawsService)
    {
        $this->withdrawsService=$withdrawsService;
    }

    public function index()
    {
        return view('Admin.User.withdraws');
    }

    //结算申请
    public function clearing()
    {
        return view('Admin.User.clearing');
    }
}