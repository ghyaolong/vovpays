<?php

namespace App\Http\User\Controllers;

use App\Services\BankCardService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    protected $userService;
    protected $bankCardService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserService $userService, BankCardService $bankCardService)
    {
        $this->userService = $userService;
        $this->bankCardService = $bankCardService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('User.Index.home');
    }

    //用户列表展示
    public function user()
    {
        $uid = Auth::user()->id;
        $list = $this->bankCardService->findStatus($uid);
        if ($list){
            $list->bankCardNo = substr_replace($list->bankCardNo, " **** **** **** ", 3, 12);
        }
//        var_dump($list);exit;
        return view('User.Index.user', compact('list'));
    }


    //修改密码
    public function editPassword(Request $request)
    {
        $data = $request->input();
        $id = $request->input('id');
        $result = $this->userService->updatePassword($id, $data);

        if ($result) {
            return ajaxSuccess('密码修改成功！');
        } else {
            return ajaxError('原密码错误，修改失败！');
        }
    }

    //开发者
    public function main()
    {
        return view('User.Index.main');
    }

    //验证器
    public function validator()
    {
        return view('User.Validator.validator');
    }

    //API
    public function api()
    {
        return view('User.Api.api');
    }
}
