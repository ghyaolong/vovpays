<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Repositories\SystemsRepository;
use App\Exceptions\CustomServiceException;
use  App;

/**
 * Class LoginLogoutService
 * @package App\Services
 */
class LoginLogoutService
{


    /**
     * 登录
     * @param string $table_name 看守器名称
     * @param array $check_data 验证字段
     * @return bool
     */
    public function Login(string $table_name, array $check_data)
    {

        $check_data['auth_code'] =$auth_code= $check_data['auth_code'] ?? null;
        unset($check_data['auth_code']);

        if (Auth::guard($table_name)->attempt($check_data)) {
            return $this->googleAuth($table_name,$auth_code);
        } else {
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

        session()->forget(Auth::guard($table_name)->getName());

        session()->regenerate();
    }

    /**google认证
     * @param $table_name
     * @param $auth_code
     * @return bool
     */
    private function googleAuth($table_name,$auth_code){
        try {
            $user = Auth::guard($table_name)->user();
            $login_permission_type = SystemsRepository::findKey('login_permission_type');
            //平台及用户开启google验证 才进行验证
            if ($user->google_key && $login_permission_type) {
                if (!App::make('googleauth')->verifyCode(Auth::guard($table_name)->user()->google_key, $auth_code)) {
                    //验证失败清除登陆信息,返回失败信息
                    $this->googleAuthFail($table_name);
                }
            }
            return true;
        } catch (CustomServiceException $e) {
            //程序异常时清除登陆信息,返回失败信息
            $this->googleAuthFail($table_name);

        }
    }

    /**
     * google验证失败后处理逻辑
     * @param Request $request
     * @param string $table_name 看守器名称
     */
    public function googleAuthFail(string $table_name)
    {
        Auth::guard($table_name)->logout();
        session()->forget(Auth::guard($table_name)->getName());
        session()->regenerate();

        throw new CustomServiceException("google认证失败");
    }
}