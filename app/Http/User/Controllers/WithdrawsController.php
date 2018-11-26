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
use Illuminate\Http\Request;

class WithdrawsController extends Controller
{
    protected $withdrawsService;
    protected $bankCardService;

    /**
     * WithdrawsController constructor.
     * @param WithdrawsService $withdrawsService
     */
    public function __construct(WithdrawsService $withdrawsService, BankCardService $bankCardService)
    {
        $this->withdrawsService = $withdrawsService;
        $this->bankCardService = $bankCardService;

    }

    public function index(Request $request)
    {
        $data=[];
        if (count($request->input()) > 1) {
            $data=$request->input();
            $list = $this->withdrawsService->searchPage($data, 10);
        }else{
            $list=$this->withdrawsService->getAllPage(10);
        }

        return view('Admin.User.withdraws', compact('list','data'));
    }


    public function clearing($id)
    {
        $list = $this->bankCardService->getAll($id);
        $clearings = $this->withdrawsService->getAllPage(6);
        return view('Admin.User.clearing', compact('list', 'clearings'));
    }

    /**
     * 申请结算
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $result = $this->withdrawsService->add($request->input());
        if ($result) {
            return ajaxSuccess('结算申请中，请留意您的账单变化！');
        } else {
            return ajaxError('发起申请失败，请稍后重试！');
        }
    }
}