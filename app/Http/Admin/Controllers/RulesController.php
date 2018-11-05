<?php

namespace App\Http\Admin\Controllers;

use App\Models\Rule;
use App\Services\RuleService;
use Illuminate\Http\Request;

class RulesController extends Controller
{

    protected $ruleService;

    public function __construct( RuleService $ruleService )
    {
        $this->ruleService = $ruleService;
    }

    public function index()
    {
        $title = '权限管理';
        $description = '权限列表';

        $list = $this->ruleService->getRuleList();
        return view('Admin.Rule.index',compact('title','description', 'list'));
    }

    /**
     * 菜单添加
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'uri'   => 'required|string',
        ],[
            'title.required' => '菜单名称不能为空',
            'uri.required'   => '菜单路由不能为空',
        ]);

        $result = $this->ruleService->add($request->all());

        if($result)
        {
            return ajaxSuccess('添加菜单成功！');
        }else{
            return ajaxError('添加菜单失败！');
        }
    }

    /**
     * 是否验证修改
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveCheck(Request $request)
    {
        $status = $request->status == 'true' ? '1' : '0';

        $result = $this->ruleService->updateCheck($request->id, $status);


        if($result)
        {
            return ajaxSuccess('修改成功！');
        }else{
            return ajaxSuccess('修改失败！');
        }
    }


}
