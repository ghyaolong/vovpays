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
use App\Services\BanksService;
use App\Http\Requests\WithdrawRequest;
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
        $uid = Auth::user()->id;

        $data = $request->input();
        $data['user_id'] = $uid;

        $search = $this->withdrawsService->searchPage($data,10);
        $list = $search['list'];
        $info = $search['info'];
        $query = $request->input();


        return view('User.Withdraws.withdraws', compact('list','info', 'query'));
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function clearing(Request $request)
    {
        $uid = Auth::user()->id;
        $list = $this->bankCardService->getUserIdAll($uid);


        $data = $request->input();
        $data['user_id'] = $uid;

        $search = $this->withdrawsService->searchPage($data,10);
        $clearings = $search['list'];
        $info = $search['info'];


        $banks= $this->banksService->findAll();

        $WithdrawRule=$this->withdrawsService->getWithdrawRule();


        return view('User.Withdraws.withdraws', compact('list','banks', 'clearings','WithdrawRule'));

    }

    /**
     * 申请结算
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(WithdrawRequest $request)
    {

        $result = $this->withdrawsService->add($request->input());

        if ($result['status']) {

            return ajaxSuccess('结算申请中，请留意您的账单变化！');

        } else {

            return ajaxError($result['msg']);
        }
    }
}