<?php

namespace App\Http\User\Controllers;

use App\Services\BankCardService;
use App\Services\OrdersService;
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

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserService $userService, BankCardService $bankCardService, OrdersService $ordersService, OrderDayCountService $orderDayCountService)
    {
        $this->userService = $userService;
        $this->bankCardService = $bankCardService;
        $this->ordersService = $ordersService;
        $this->orderDayCountService = $orderDayCountService;
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
        $user=$this->userService->findId($query['user_id']);
        //订单金额
        $orderInfoSum = $this->ordersService->orderInfoSum($query);
        $order_day_count = json_encode(convert_arr_key($this->orderDayCountService->getOrderSevenDaysCount($query), 'tm'));
        return view('User.Index.home', compact('user','orderInfoSum', 'order_day_count'));
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
    public function main()
    {
        return view('User.Index.main');
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
