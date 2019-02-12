<?php

namespace App\Http\Admin\Controllers;

use App\Http\Requests\LoginRequest;
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
        $google_auth=isset(Cache()->get('systems')['login_permission_type']->value) && Cache()->get('systems')['login_permission_type']->value == '1';
        return view('Admin.Login.login',compact('google_auth'));
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {

        $check_data = $request->only('username','password','auth_code');

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
