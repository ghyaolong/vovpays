<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/12/21
 * Time: 15:32
 */

namespace App\Http\Admin\Controllers;


use App\Services\AccountPhoneService;
use App\Services\CheckUniqueService;
use Illuminate\Http\Request;

class AccountPhoneController extends Controller
{
    protected $accountPhoneService;
    protected $checkUniqueService;
    protected $uid = 100000; // 总后台挂号,默认用户id

    public function __construct(AccountPhoneService $accountPhoneService, CheckUniqueService $checkUniqueService)
    {
        $this->accountPhoneService = $accountPhoneService;
        $this->checkUniqueService = $checkUniqueService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data = $request->input();
        if ($request->type == '0') {
            $data['accountType'] = 'wechat';
            $title = '微信账号';

        } elseif ($request->type == '1') {
            $title = '支付宝账号';
            $data['accountType'] = 'alipay';

        }
        $data['user_id'] = $this->uid;

        $list = $this->accountPhoneService->getAllPage($data, 6);



        return view("Admin.AccountPhone.{$data['accountType']}", compact('list','title'));
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
            'account'        => 'required|unique:account_phones,account,'.$id,
        ],[
            'account.unique'           => '用户名已存在',
        ]);

        if (!empty($id)) {
            $result = $this->accountPhoneService->update($id, $this->uid, $request->input());
            if ($result) {
                return ajaxSuccess('编辑成功！');
            } else {
                return ajaxError('编辑失败！');
            }
        } else {

            $request->merge(['user_id' => $this->uid]);
            $result = $this->accountPhoneService->add($request->input());
            if ($result) {
                return ajaxSuccess('账号添加成功！');
            } else {
                return ajaxError('账号添加失败！');
            }
        }

    }

    /**
     * 检测唯一性
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkUnique(Request $request)
    {
        $result = $this->checkUniqueService->check('account_phones', $request->type, $request->value, $request->id, $request->name);
        if ($result) {
            return response()->json(array("valid" => "true"));
        } else {
            return response()->json(array("valid" => "false"));
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
        $result = $this->accountPhoneService->update($request->id, $this->uid, $data);
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
        $result = $this->accountPhoneService->findIdAndUserId($request->id, $this->uid);
        if ($result) {
            return ajaxSuccess('获取成功！', $result->toArray());
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
        $result = $this->accountPhoneService->del($request->id, $this->uid);
        if ($result) {
            return ajaxSuccess('账号已删除！');
        } else {
            return ajaxError('删除失败！');
        }
    }

}