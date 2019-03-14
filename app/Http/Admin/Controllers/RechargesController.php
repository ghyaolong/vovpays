<?php

namespace App\Http\Admin\Controllers;

use App\Services\RechargeService;
use Illuminate\Http\Request;


class RechargesController extends Controller
{
    protected $rechargeService;

    public function __construct(RechargeService $rechargeService)
    {
        $this->rechargeService = $rechargeService;
    }

    //
    public function index(Request $request){

        $query=$request->input();

        $list  = $this->rechargeService->getAllPage($query);

        $title      = '商户充值';
        return view("Admin.Recharge.index",compact('list','title','query'));
    }


    public function saveStatus(Request $request){

        $id = $request->id;

        $result=$this->rechargeService->RechargeSuccess($id);

        if ($result) {
            return ajaxSuccess('操作成功');
        } else {
            return ajaxError('操作失败！');
        }

    }
}
