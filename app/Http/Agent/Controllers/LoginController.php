<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/11/27
 * Time: 16:25
 */

namespace App\Http\Agent\Controllers;

use App\Services\LoginLogoutService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController
{

//    use AuthenticatesAgent;
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/Agent';
    protected $loginLogoutService;
    protected $userService;


    /**
     * LoginController constructor.
     * @param LoginLogoutService $loginLogoutService
     */
    public function __construct(LoginLogoutService $loginLogoutService, UserService $userService)
    {
        $this->loginLogoutService = $loginLogoutService;
        $this->userService = $userService;
    }


    /**
     * 登录页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {
        $user = Auth::guard('agent')->user();
        if ($user) return redirect('agent');
        return view('Agent.Login.login');
    }

    /**
     * 代理商登录
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $check_data = $request->only('username', 'password');
        $user = $this->userService->findUser($request->input('username'));
        if ($user['group_type'] !== 2) {
            return ajaxError('您不是代理商，无权登录！');
        }
        $result = $this->loginLogoutService->Login('agent', $check_data);
        if ($result) {
            return ajaxSuccess('登录成功，欢迎来到后台管理系统。');
        } else {
            return ajaxError('用户名或密码错误，请重新输入！');
        }
    }

    /**
     * 登出
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $this->loginLogoutService->destroy($request,'agent');

        return redirect()->route('agent.login');
    }


}