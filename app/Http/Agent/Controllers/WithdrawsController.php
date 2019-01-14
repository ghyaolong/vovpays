<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/11/28
 * Time: 16:24
 */

namespace App\Http\Agent\Controllers;


use App\Services\BankCardService;
use App\Services\BanksService;
use App\Services\WithdrawsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WithdrawsController extends Controller
{
    protected $withdrawsService;
    protected $bankCardService;
    protected $banksService;

    /**
     * WithdrawsController constructor.
     * @param WithdrawsService $withdrawsService
     */
    public function __construct(WithdrawsService $withdrawsService, BankCardService $bankCardService, BanksService $banksService)
    {
        $this->withdrawsService = $withdrawsService;
        $this->bankCardService = $bankCardService;
        $this->banksService = $banksService;

    }

    /**
     * 查询分页
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = $request->input();
        $data = [];

        if (count($request->input()) > 1) {

            $data = $request->input();

            $list = $this->withdrawsService->searchPage($data, 10);

        } else {

            $list = $this->withdrawsService->getAllPage(10);
        }


        return view('Agent.Withdraws.withdraws', compact('list', 'data', 'query'));
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function clearing()
    {
        $uid = Auth::user()->id;
        $list = $this->bankCardService->getUserIdAll($uid);

        $clearings = $this->withdrawsService->getAllPage(6);

        $banks= $this->banksService->findAll();

        return view('Agent.Withdraws.clearing', compact('list','banks', 'clearings'));
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