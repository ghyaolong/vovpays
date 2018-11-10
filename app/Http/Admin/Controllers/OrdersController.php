<?php

namespace App\Http\Admin\Controllers;

use App\Services\ChannelPaymentsService;
use App\Services\ChannelService;
use App\Services\OrdersService;
use Illuminate\Http\Request;

class OrdersController extends Controller
{

    protected $ordersService;
    protected $channelService;
    protected $channelPaymentsService;

    public function __construct( OrdersService $ordersService, ChannelService $channelService, ChannelPaymentsService $channelPaymentsService)
    {
        $this->ordersService  = $ordersService;
        $this->channelService = $channelService;
        $this->channelPaymentsService = $channelPaymentsService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $title = '订单管理';
        $query = $request->query();

        if(count($query))
        {
            $list = $this->ordersService->searchPage($query, 10);
        }else{
            $list = $this->ordersService->getAllPage(10);
        }

        $chanel_list    = $this->channelService->getAll();
        $payments_list  = $this->channelPaymentsService->getAll();

        return view('Admin.Orders.index',compact('title', 'list', 'query', 'chanel_list','payments_list'));
    }


    /**
     * 详情
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $rule =$this->ordersService->findId($id);
        return ajaxSuccess('获取成功',$rule);
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

        if($result)
        {
            return ajaxSuccess('修改成功！');
        }else{
            return ajaxError('修改失败！');
        }
    }

    /**
     * 删除
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        $result = $this->ordersService->destroy($request->id);
        if($result)
        {
            return ajaxSuccess('删除成功！');
        }else{
            return ajaxError('删除失败！');
        }
    }

}
