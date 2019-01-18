<?php

namespace App\Http\Admin\Controllers;

use App\Services\ChannelPaymentsService;
use App\Services\ChannelService;
use App\Services\DownNotifyContentService;
use App\Services\OrdersService;
use Illuminate\Http\Request;

class OrdersController extends Controller
{

    protected $ordersService;
    protected $channelService;
    protected $channelPaymentsService;
    protected $downNotifyContentService;

    public function __construct(OrdersService $ordersService, ChannelService $channelService, ChannelPaymentsService $channelPaymentsService,
                                DownNotifyContentService $downNotifyContentService)
    {
        $this->ordersService = $ordersService;
        $this->channelService = $channelService;
        $this->channelPaymentsService = $channelPaymentsService;
        $this->downNotifyContentService = $downNotifyContentService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $title = '订单管理';
        $query = $request->query();
        if (count($query)) {
            $list = $this->ordersService->searchPage($query, 10);
            //订单金额
            $orderInfoSum = $this->ordersService->orderInfoSum($query);
            //手续费
        } else {
            $query = [];
            $list = $this->ordersService->getAllPage($query,10);
            //订单金额
            $orderInfoSum = $this->ordersService->orderInfoSum($query);
        }

        $chanel_list = $this->channelService->getAll();
        $payments_list = $this->channelPaymentsService->getAll();

        return view('Admin.Orders.index', compact('title', 'list', 'query', 'chanel_list', 'payments_list','orderInfoSum'));

    }


    /**
     * 详情
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $rule = $this->ordersService->findId($id);
        return ajaxSuccess('获取成功', $rule);
    }

    /**
     * 状态变更
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveStatus(Request $request)
    {
        $data['status'] = $request->status;
        $result = $this->ordersService->updateStatus($request->id, $data);

        if ($result) {
            return ajaxSuccess('修改成功！');
        } else {
            return ajaxError('修改失败！');
        }
    }

    /**
     * 订单补发通知
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reissue(Request $request)
    {

        $order = $this->ordersService->findId($request->id,'collection');

        if(!$order || $order->status != 1)
        {
            return ajaxError('订单不存在或未支付');
        }

        if($this->downNotifyContentService->send($order))
        {
            return ajaxSuccess('已发送');
        }else{
            return ajaxError('发送失败');
        }
    }
}
