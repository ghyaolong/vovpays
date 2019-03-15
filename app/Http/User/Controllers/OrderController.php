<?php

namespace App\Http\User\Controllers;

use App\Services\ChannelPaymentsService;
use App\Services\ChannelService;
use App\Services\OrdersService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\StatisticalService;
use App\Jobs\SendOrderAsyncNotify;
use App\Services\DownNotifyContentService;

class OrderController extends Controller
{
    protected $ordersService;
    protected $channelService;
    protected $channelPaymentsService;
    protected $statisticalService;
    protected $downNotifyContentService;

    public function __construct(DownNotifyContentService $downNotifyContentService,OrdersService $ordersService, ChannelService $channelService, ChannelPaymentsService $channelPaymentsService,StatisticalService $statisticalService)
    {
        $this->ordersService = $ordersService;
        $this->channelService = $channelService;
        $this->channelPaymentsService = $channelPaymentsService;
        $this->statisticalService = $statisticalService;
        $this->downNotifyContentService = $downNotifyContentService;
    }

    /**
     * Show the application dashboard.
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $uid = Auth::user()->id;
        $query = $request->input();
        $query['user_id'] = $uid;

        $search = $this->ordersService->searchPage($query, 10);
        $list = $search['list'];
        $orderInfoSum = $search['info'];


        $chanel_list = $this->channelService->getAll();
        $payments_list = $this->channelPaymentsService->getAll();

        unset($query['_token']);
        unset($query['user_id']);

        return view('User.Order.order', compact('list', 'query', 'chanel_list', 'payments_list', 'orderInfoSum'));
    }

    /**
     * 详情
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $query['id'] = $id;
        $rule = $this->ordersService->findId($id);
        if (isset($rule) && $rule['user_id']==Auth::user()->id) {
            return ajaxSuccess('获取成功', $rule);
        } else {
            return ajaxError('获取失败');
        }

    }

    /**
     * 状态变更
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveStatus(Request $request)
    {
        $uid = Auth::user()->id;
        // 只能是总管理能修改
        if(env('ADD_ACCOUNT_TYPE') != 1)
        {
            return ajaxError('无权限！');
        }

        $order = $this->ordersService->findId($request->id,'collection');
        if(!$order) return ajaxError('修改失败！');

        if($order->user_id != $uid){
            return ajaxError('无权限！');
        }

        if($order->status != 0) return ajaxError('修改失败！');
        $data['status'] = 1;
        $result = $this->ordersService->updateStatus($request->id, $data);
        if(!$result)return ajaxError('修改失败！');

        // 商户收益增加
        $this->statisticalService->updateUseridHandlingFeeBalanceIncrement($order->user_id,$order->userAmount);

        // 代理收益增加
        if($order->agentAmount > 0)
        {
            $this->statisticalService->updateUseridHandlingFeeBalanceIncrement($order->agent_id,$order->agentAmount);
        }

        SendOrderAsyncNotify::dispatch($order)->onQueue('orderNotify');
        return ajaxSuccess('修改成功！');

    }

    /**
     * 订单补发通知
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reissue(Request $request)
    {

        $order = $this->ordersService->findId($request->id,'collection');

        if(!$order || $order->status != 1 || $order->user_id != Auth::user()->id)
        {
            return ajaxError('不能补发通知');
        }

        if($this->downNotifyContentService->send($order))
        {
            return ajaxSuccess('已发送');
        }else{
            return ajaxError('发送失败');
        }
    }
}
