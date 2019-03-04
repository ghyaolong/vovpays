<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/1/15
 * Time: 17:57
 */

namespace App\Http\Admin\Controllers;

use App\Services\CheckUniqueService;
use App\Services\ChannelService;
use App\Services\ChannelPaymentsService;
use App\Services\AccountUpperService;
use Illuminate\Http\Request;

class AccountUpperController extends Controller
{
    protected $checkUniqueService;
    protected $channelService;
    protected $paymentsService;
    protected $accountUpperService;
    protected $uid = 100000;

    public function __construct(CheckUniqueService $checkUniqueService, ChannelService $channelService, AccountUpperService $AccountUpperService,ChannelPaymentsService $paymentsService)
    {
        $this->channelService     = $channelService;
        $this->paymentsService    = $paymentsService;
        $this->accountUpperService = $AccountUpperService;
        $this->checkUniqueService = $checkUniqueService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data = $request->input();
        $data['user_id'] = $this->uid;
        $module = 'Admin';
        $list = $this->accountUpperService->getAllPage(10);
        $channel = $this->channelService->getAll();

        $query = $request->query();
        return view("Common.upper", compact('list', 'query','channel','module'));


    }

    /**
     * 添加
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $id = $request->id ?? '';
        $this->validate($request, [
            'account' => 'required',
            'channel_id'=>'required',
            'channel_payment_id'=>'required'
        ], [
            'cardNo.required' => '账号必填!',
            'channel_id.required' => '通道必选!',
            'channel_payment_id.required' => '支付方式必选!',
        ]);

        if (!empty($id)) {
            $result = $this->accountUpperService->update($id, $request->input());
            if ($result) {
                return ajaxSuccess('编辑成功！');
            } else {
                return ajaxError('编辑失败！');
            }
        } else {

            $result = $this->accountUpperService->add($request->input());
            if ($result) {
                return ajaxSuccess('账号添加成功！');
            } else {
                return ajaxError('账号添加失败！');
            }
        }

    }

    /**
     * 编辑状态
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveStatus(Request $request)
    {
        $data['status'] = $request->status == 'true' ? '1' : '0';
        $result = $this->accountUpperService->update($request->id, $data);
        if ($result) {
            return ajaxSuccess('修改成功！');
        } else {
            return ajaxError('修改失败！');
        }
    }


    /**
     * 编辑
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Request $request)
    {
        $result = $this->accountUpperService->findId($request->id);
        if ($result) {
            $channel_payment = $this->paymentsService->findId($result['channel_payment_id']);
            $data = array('data'=>$result,'payment'=>$channel_payment);
            return ajaxSuccess('获取成功！', $data);
        } else {
            return ajaxError('获取失败！');
        }
    }

    /**
     * 删除
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        $result = $this->accountUpperService->destroy($request->id);
        if ($result) {
            return ajaxSuccess('账号已删除！');
        } else {
            return ajaxError('删除失败！');
        }
    }

    /**
     * 获取通道支付方式
     * @param
     */
    public function paymentget(Request $request){
        $id = $request->input('channid');
        $payment = array();
        if($id){
            $payment = $this->paymentsService->channelid($id);
        }
        if(count($payment)){
            return ajaxSuccess('获取成功',$payment->toArray());
        }
        return ajaxError('无数据');
    }

}