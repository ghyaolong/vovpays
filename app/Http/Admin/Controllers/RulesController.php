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
