<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/11/27
 * Time: 11:45
 */

namespace App\Http\Agent\Controllers;


use App\Services\AgentService;
use App\Services\CheckUniqueService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    protected $userService;
    protected $checkUniqueService;

    /**
     * UserController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService,CheckUniqueService $checkUniqueService)
    {
        $this->userService = $userService;
        $this->checkUniqueService=$checkUniqueService;
    }

    /**
     * 下属用户展示
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data = $request->input();
        $pid = Auth::user()->id;
        $list = $this->userService->getAllParentPage($pid, 10);
        return view('Admin.Agent.user', compact('list', 'data'));
    }

    public function add(Request $request)
    {
        $result = $this->userService->add($request->input());

        if ($result) {
            return ajaxSuccess('商户添加成功!');
        } else {
            return ajaxError('商户添加失败!');
        }


    }

    /**
     * 唯一验证
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkUnique(Request $request)
    {
//        var_dump($request->type);exit;
        $result = $this->checkUniqueService->check('users', $request->type, $request->value, $request->id);

        if($result){
            return  response()->json(array("valid"=>"true"));
        }else{
            return  response()->json(array("valid"=>"false"));
        }
    }


}