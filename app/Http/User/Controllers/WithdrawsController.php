<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/11/20
 * Time: 9:55
 */

namespace App\Http\User\Controllers;


use App\Services\BankCardService;
use App\Services\WithdrawsService;

class WithdrawsController extends Controller
{
    protected $withdrawsService;
    protected $bankCardService;

    /**
     * WithdrawsController constructor.
     * @param WithdrawsService $withdrawsService
     */
    public function __construct(WithdrawsService $withdrawsService,BankCardService $bankCardService)
    {
        $this->withdrawsService=$withdrawsService;
        $this->bankCardService=$bankCardService;
    }

    public function index()
    {
        return view('Admin.User.withdraws');
    }

    //结算申请
    public function clearing($id)
    {
        $list = $this->bankCardService->getAll($id);
        return view('Admin.User.clearing',compact('list'));
    }
}