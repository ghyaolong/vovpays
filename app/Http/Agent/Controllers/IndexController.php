<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/11/27
 * Time: 10:54
 */

namespace App\Http\Agent\Controllers;


use App\Services\UserService;
use App\Services\BankCardService;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    protected $bankCardService;
    protected $userService;

    /**
     * IndexController constructor.
     * @param BankCardService $bankCardService
     */
    public function __construct(BankCardService $bankCardService,UserService $userService)
    {
        $this->bankCardService = $bankCardService;
        $this->userService = $userService;
    }


    /**
     * 后台主页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {
        $uid=Auth::user()->id;
        //获取默认银行卡信息
        $list = $this->bankCardService->findStatus($uid);

        //获取用户基本信息
        $user=$this->userService->findId($uid);

        return view('Agent.Index.index',compact('list','user'));
    }


    /**
     * 商户费率
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function rate()
    {
        return view('Agent.Index.memberRate');
    }

}