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
    public function user(Request $request)
    {
        $data = $request->input();
        if (count($data)) {
            $users = $this->userService->searchPage($data, 10);
        } else {
            $users = $this->userService->getAllGroupPage(1, 10);
        }

        $agent_list = $this->userService->getGroupAll(2);
        return view('Admin.User.user', compact('users', 'data', 'agent_list'));
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
    //删除
    public function destroy(Request $request)
    {
        $result = $this->userService->destroy($request->id);
        if ($result) {
            return ajaxSuccess('删除成功！');
        } else {
            return ajaxError('删除失败！');
        }
    }

    //修改密码
    public function editPassword(Request $request)
    {
        var_dump($request->input());
        exit;
    }
}
