<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/11/27
 * Time: 10:54
 */

namespace App\Http\Agent\Controllers;


use App\Services\AgentService;
use App\Services\BankCardService;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    protected $bankCardService;

    /**
     * IndexController constructor.
     * @param BankCardService $bankCardService
     */
    public function __construct(BankCardService $bankCardService)
    {
        $this->bankCardService = $bankCardService;
    }


    /**
     * 后台主页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {
        $uid=Auth::user()->id;
        $list = $this->bankCardService->findStatus($uid);
//        dd($list->bankCardNo);exit;
        $list->bankCardNo=substr_replace($list->bankCardNo," **** **** **** ",3,12);
//        dd($list->bankCardNo);exit;
        return view('Admin.Agent.index',compact('list'));
    }

    /**
     * 推广地址
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function extension()
    {
        return view('Admin.Agent.extension');
    }

    /**
     * 商户费率
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function rate()
    {
        return view('Admin.Agent.memberRate');
    }

}