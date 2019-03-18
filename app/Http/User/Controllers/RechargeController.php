<?php

namespace App\Http\User\Controllers;

use App\Services\RechargeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class RechargeController extends Controller
{
    protected $rechargeService;

    public function __construct(RechargeService $rechargeService)
    {
        $this->rechargeService = $rechargeService;
    }

    public function index(Request $request)
    {
        $query = $request->query();
        if(isset($query['order_no']) && $query['order_no']){
            $list  = $this->rechargeService->findUserIdAndOrderNo(Auth::user()->id,$request->order_no);
        }else{
            $list  = $this->rechargeService->findUserIdAll(Auth::user()->id,15);
        }

        $module='User';

        return view('Common.recharge',compact('list','query','module'));
    }

    public function store(Request $request)
    {
        if( $request->money < 100 ){
            return ajaxError('充值金额需要大于100');
        }

        if(!$data = $this->rechargeService->add($request->money))
        {
            return ajaxError('充值失败');
        };

        return ajaxSuccess('',$data);
    }

    /**
     * @param Request $request
     * @return string
     */
    public function callback(Request $request)
    {
        Redis::select(1);
        $order_no = $request->trade_no;

        if(!Redis::exists($order_no))
        {
            return json_encode(array('msg'=>'','status'=>'expired'));
        }

        $data = Redis::hGetAll($order_no);
        if($data['status'] == 0)
        {
            return json_encode(array('msg'=>'','status'=>'inprogress'));

        }else if($data['status'] == '1'){
            return json_encode(array('msg'=>'','status'=>'success'));
        }
    }
}
