<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/11/28
 * Time: 16:09
 */

namespace App\Http\Agent\Controllers;


use App\Http\Agent\Controllers\Controller;
use App\Services\BankCardService;
use App\Services\BanksService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BankCardController extends Controller
{
    protected $bankCardService;
    protected $banksService;

    public function __construct(BankCardService $bankCardService,BanksService $banksService)
    {
        $this->bankCardService = $bankCardService;
        $this->banksService = $banksService;
    }

    /*
     * 银行卡管理
     */
    public function index()
    {
        $uid=Auth::user()->id;
        $lists = $this->bankCardService->getUserIdAll($uid);
        $banks= $this->banksService->findAll();

        return view('Agent.BankCard.bankCard', compact('lists','banks'));
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
        } else {
//            return ajaxError('修改失败！');
            return ajaxSuccess('修改成功！');
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