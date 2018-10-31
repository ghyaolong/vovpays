<?php

namespace App\Http\Admin\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/admin';

    /**
    * 显示后台登录模板
    */
    public function show()
    {
        return view('admin.login.login');
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

        if ($this->guard()->attempt($request->only('username','password'))) {
            return ajaxSuccess('登录成功，欢迎来到管理系统！');
        }else{
            return ajaxError('用户名或者密码错误');
        }
    }


    /**
     * 退出登录
     */
    public function destroy(Request $request)
    {
        $this->guard()->logout();

        $request->session()->forget($this->guard()->getName());

        $request->session()->regenerate();

        return redirect()->route('admin.login');
    }

    /**
    * 使用 admin guard
    */
    protected function guard()
    {
        return Auth::guard('admin');
    }
}
