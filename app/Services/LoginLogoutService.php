<?php
namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

/**
 * Class LoginLogoutService
 * @package App\Services
 */
class LoginLogoutService
{
    /**
     * 登录
     * @param string $table_name 看守器名称
     * @param array $check_data  验证字段
     * @return bool
     */
    public function Login( string $table_name, array $check_data)
    {

        if ( Auth::guard($table_name)->attempt($check_data) ) {
            return true;
        }else{
            return false;
        }
    }

    /**
     * 退出
     * @param Request $request
     * @param string $table_name 看守器名称
     */
    public function destroy(Request $request, string $table_name)
    {
        Auth::guard($table_name)->logout();

        $request->session()->forget(Auth::guard($table_name)->getName());

        $request->session()->regenerate();
    }
}