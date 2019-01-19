<?php

namespace App\Http\User\Controllers;

use App\Services\BankCardService;
use App\Services\OrdersService;
use App\Services\StatisticalService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\OrderDayCountService;

class IndexController extends Controller
{
    protected $userService;
    protected $bankCardService;
    protected $orderDayCountService;
    protected $ordersService;
    protected $statisticalService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(StatisticalService $statisticalService, UserService $userService, BankCardService $bankCardService, OrdersService $ordersService, OrderDayCountService $orderDayCountService)
    {
        $this->userService = $userService;
        $this->bankCardService = $bankCardService;
        $this->ordersService = $ordersService;
        $this->orderDayCountService = $orderDayCountService;
        $this->statisticalService = $statisticalService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = $request->input();
        $query['user_id'] = Auth::user()->id;

        $user_day_count = $this->orderDayCountService->findDayAndUserCount($query['user_id']);
        $order_day_count = json_encode(convert_arr_key($this->orderDayCountService->getOrderUserSevenDaysCount($query), 'tm'));
        return view('User.Index.home', compact('user_day_count', 'order_day_count'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {
        $uid        = Auth::user()->id;
        $user       = $this->userService->findId($uid);
        $statistical= $this->statisticalService->findUserId($uid);
        return view('User.Index.index', compact('user','statistical'));
    }

    //用户列表展示
    public function user()
    {
        $uid = Auth::user()->id;
        $list = $this->bankCardService->findStatus($uid);
        if ($list) {
            $list->bankCardNo = substr_replace($list->bankCardNo, " **** **** **** ", 3, 12);
        }
        return view('User.Index.user', compact('list'));
    }


    //修改密码
    public function editPassword(Request $request)
    {
        $data = $request->input();
        $id = Auth::user()->id;
        $result = $this->userService->updatePassword($id, $data);

        if ($result) {
            return ajaxSuccess('密码修改成功！');
        } else {
            return ajaxError('原密码错误，修改失败！');
        }
    }

    //开发者
    public function main(Request $request)
    {

        $httpType = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
        $host = $httpType . $_SERVER['HTTP_HOST'];

        return view('User.Index.main', compact('host'));
    }

    //验证器
    public function validator()
    {
        return view('User.Validator.validator');
    }

    //API
    public function api()
    {
        return view('User.Api.api');
    }
}
