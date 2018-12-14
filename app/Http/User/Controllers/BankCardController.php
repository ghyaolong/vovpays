<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/11/17
 * Time: 13:51
 */

namespace App\Http\User\Controllers;


use App\Services\BankCardService;
use Illuminate\Http\Request;

class BankCardController extends Controller
{
    protected $bankCardService;

    public function __construct(BankCardService $bankCardService)
    {
        $this->bankCardService = $bankCardService;
    }

    /*
     * 银行卡管理
     */
    public function bankCard($id)
    {
        $lists = $this->bankCardService->getAll($id);
        return view('Admin.User.bankCard', compact('lists'));
    }


    /**
     * 变更状态
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveStatus(Request $request)
    {
        $data['status'] = $request->status == 'true' ? '1' : '0';
        $data['user_id'] = $request->user_id;
        $result = $this->bankCardService->updateStatus($request->id, $data);
        if ($result) {
            return ajaxSuccess('修改成功！');
        } elseif ($result === false) {
            return ajaxError('修改失败，只能有一张卡为启用状态！');
        } else {
            return ajaxError('修改失败！');
        }
    }

    /*
     * 银行卡添加
     */
    public function store(Request $request)
    {
        $id = $request->id ? $request->id : '';

        if ($id) {
            $result = $this->bankCardService->update($request->id, $request->input());
            if ($result) {
                return ajaxSuccess('编辑成功！');
            } else {
                return ajaxError('编辑失败！');
            }
        } else {
            $result = $this->bankCardService->add($request->input());
            if ($result) {
                return ajaxSuccess('添加银行卡成功！');
            } else {
                return ajaxError('添加银行卡失败！');
            }
        }

    }

    /**
     * 编辑
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        $result = $this->bankCardService->findId($id);
        return ajaxSuccess('获取成功', $result->toArray());
    }

    /**
     * 删除
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        $result = $this->bankCardService->destroy($request->id);
        if ($result) {
            return ajaxSuccess('删除成功！');
        } else {
            return ajaxError('删除失败！');
        }
    }


}