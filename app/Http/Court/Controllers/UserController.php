<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/11/27
 * Time: 11:45
 */

namespace App\Http\Court\Controllers;


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
        $query = $request->input();
        $pid = Auth::user()->id;

        if(count($query))
        {
            $query['parentId']=$pid;
            $list = $this->userService->searchPage($query, 10);
        }else{
            $list = $this->userService->getParentIdPage($pid,10);
        }


        return view('Court.User.user',compact( 'list', 'query'));


    }

    /**
     * 添加
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
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
     * 下属商户状态修改
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveStatus(Request $request)
    {
        $data['status'] = $request->status == 'true' ? '1' : '0';

        $result = $this->userService->updateStatus($request->id, $data);

        if($result)
        {
            return ajaxSuccess('修改成功！');
        }else{
            return ajaxError('修改失败！');
        }

    }
    /**
     * 唯一验证
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkUnique(Request $request)
    {
        $result = $this->checkUniqueService->check('users', $request->type, $request->value, $request->id);

        if($result){
            return  response()->json(array("valid"=>"true"));
        }else{
            return  response()->json(array("valid"=>"false"));
        }
    }


}