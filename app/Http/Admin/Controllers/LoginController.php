<?php

namespace App\Http\Admin\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Services\LoginLogoutService;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/admin';
    protected $loginLogoutService;

    public function __construct(LoginLogoutService $loginLogoutService)
    {
        $this->loginLogoutService = $loginLogoutService;
    }

    /**
    * 显示后台登录模板
    */
    public function show()
    {
        $user = Auth::guard('admin')->user();
        if ($user) return redirect('admin');
        return view('Admin.Login.login');
    }


    /**
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


        $check_data = $request->only('username','password');
        $result = $this->loginLogoutService->Login('admin',$check_data);
        if($result)
        {
            return ajaxSuccess('登录成功，欢迎来到后台管理系统。');
        }else{
            return ajaxSuccess('用户名或密码错误，请重新输入！');
        }

    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $this->loginLogoutService->destroy($request,'admin');

        return redirect()->route('admin.login');
    }
}
