<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/11/27
 * Time: 16:25
 */

namespace App\Http\Court\Controllers;

use App\Services\LoginLogoutService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/Court';
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
        $user = Auth::guard('court')->user();
        if ($user) return redirect('court');
        return view('Court.Login.login');
    }

    /**
     * 场外第三方登录
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|string',
            'password' => 'required',
            'captcha'  => 'required|captcha',
        ],[
            'captcha.required' => '验证码不能为空',
            'captcha.captcha'  => '请输入正确的验证码',
        ]);
        // 添加验证用户登录标识
        $request->merge(['group_type' => '3']);

        $check_data = $request->only('username','password','group_type');
        $result = $this->loginLogoutService->Login('court',$check_data);
        if($result)
        {
            return ajaxSuccess('登录成功，欢迎来到后台管理系统。');
        }else{
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
        $this->loginLogoutService->destroy($request,'court');

        return redirect()->route('court.login');
    }


}