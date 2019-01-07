<?php
/**
 * 收款助手登录
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019/1/7
 * Time: 11:49
 */

namespace App\Http\Pay\Controllers;

use App\Services\AccountPhoneService;
use App\Services\UserService;
use App\Services\AdminsService;
use Illuminate\Http\Request;

class PhoneLoginController extends Controller
{

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $userService;
    protected $adminsService;
    protected $accountPhoneService;

    /**
     * @param UserService $userService
     * @param AdminsService $adminsService
     * @param AccountPhoneService $accountPhoneService
     */
    public function __construct(UserService $userService, AdminsService $adminsService, AccountPhoneService $accountPhoneService)
    {
        $this->userService   = $userService;
        $this->adminsService = $adminsService;
        $this->accountPhoneService = $accountPhoneService;
    }

    public function login(Request $request)
    {
        $fans = $this->userService->findUsernameAndStatus($request->input('username'),1);
        if(!$fans)
        {
            $fans = $this->adminsService->findUsernameAndStatus($request->input('username'),1);
            if($fans)
            {
                $fans->apikey = md5('345534ewr');
            }

        }

        if(!$fans)
        {
            return json_encode(array('msg'=>'用户名或密码错误'));
        }

        if (!password_verify($request->input('password'), $fans->password)) {
            return json_encode(array('msg'=>'用户名或密码错误'));
        }

        $account_list = $this->accountPhoneService->getPhoneidAndStatusAndUserid($request->input('phoneid'),1,$fans->id);
        if(!count($account_list))
        {
            return json_encode(array('msg'=>'后台未配置收款账号'));
        }

        foreach ($account_list as $k=>$v)
        {
            switch ($v->accountType){
                case "微信":
                    $wx_account = $v->account;
                    break;
                case "支付宝":
                    $alipay_account = $v->account;
                    break;
            }
        }

        $data = array(
            'alipayAccount' => $alipay_account ?: '',
            'wechatAccount' => $wx_account ?: '',
            'key'           => $fans->apiKey,
            'host'          => env('MQ_HOST'),
            'Port'          => env('MQ_PORT'),
            'virtualhost'   => env('MQ_VHOST'),
            'qname'         => env('MQ_USER'),
            'qpassword'     => env('MQ_PWD'),
            'msg'           => '',
            'notifyUrl'     => '/Pay_Exemption_notify.html'
        );
        return json_encode($data);

    }
}
