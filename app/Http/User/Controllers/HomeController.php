<?php

namespace App\Http\User\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $userService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.user.home');
    }

    //用户列表展示
    public function user()
    {
//        $users = $this->userService->getAll(1);
//        var_dump($users);exit;
        return view('admin.user.user',compact('users'));
    }

    //提现页面
    public function settlement()
    {
        return view('admin.user.settlement');
    }

    //银行卡管理
    public function bank()
    {
        return view('admin.user.bank');
    }
}
