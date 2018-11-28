<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/11/27
 * Time: 10:54
 */

namespace App\Http\Agent\Controllers;


use App\Services\AgentService;

class IndexController extends Controller
{
    protected $agentService;

    /**
     * IndexController constructor.
     * @param AgentService $agentService
     */
//    public function __construct(AgentService $agentService)
//    {
//        $this->agentService = $agentService;
//    }


    /**
     * 后台主页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {
        return view('Admin.Agent.index');
    }

    /**
     * 推广地址
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function extension()
    {
        return view('Admin.Agent.extension');
    }

    /**
     * 商户费率
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function rate()
    {
        return view('Admin.Agent.memberRate');
    }

}