<?php

namespace App\Http\User\Controllers;

use App\Services\LoginLogoutService;
use App\Services\UserService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    protected $loginLogoutService;
    protected $userService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        $this->middleware('guest')->except('logout');
//    }
    public function __construct(UserService $userService,LoginLogoutService $loginLogoutService)
    {
        $this->loginLogoutService=$loginLogoutService;
        $this->userService=$userService;
    }


    public function show()
    {
        return view('admin.user.login');
    }

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
//        var_dump($check_data);exit;
        $result = $this->loginLogoutService->Login('user',$check_data);
        if($result)
        {
            return ajaxSuccess('登录成功，欢迎来到后台管理系统。');
        }else{
            return ajaxSuccess('用户名或密码错误，请重新输入！');
        }
    }

    /*
     * 登出
     */
    public function destroy(Request $request)
    {
        $this->loginLogoutService->destroy($request,'user');

        return redirect()->route('user.login');
    }

    //登陆页面
    public function registerShow()
    {
        return view('admin.user.register');
    }

    public function register(Request $request)
    {
        $data=$request->input();
        unset($data['rpassword']);
        $result=$this->userService->add($data);
        if($result)
        {
            return ajaxSuccess('注册成功，请登录。');
        }else{
            return ajaxSuccess('系统繁忙，请稍后重试！');
        }
    }
}
