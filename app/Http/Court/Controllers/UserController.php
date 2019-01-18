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
use App\Services\QuotalogService;

class UserController extends Controller
{

    protected $userService;
    protected $checkUniqueService;
    protected $quotalogService;

    /**
     * UserController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService, CheckUniqueService $checkUniqueService, QuotalogService $quotalogService)
    {
        $this->userService = $userService;
        $this->checkUniqueService = $checkUniqueService;
        $this->quotalogService    = $quotalogService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $courtId = Auth::user()->id;

        $court = $this->userService->findId($courtId);
        $list = $this->quotalogService->searchPage(['user_id'=>$courtId],10);

        return view('Court.User.user', compact('court','list'));


    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $id = $request->id ? $request->id : '';

        if($id)
        {
            $result = $this->userService->update($request->id, $request->all());

            if($result)
            {
                return ajaxSuccess('修改成功！');
            }else{
                return ajaxError('修改失败！');
            }
        }else{
            return ajaxError('修改失败！');
        }
    }

    /**
     * 编辑
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        $rule =$this->userService->findId($id);
        return ajaxSuccess('获取成功',$rule->toArray());
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

        if ($result) {
            return ajaxSuccess('修改成功！');
        } else {
            return ajaxError('修改失败！');
        }

    }

    /**
     * 获取当前用户额度
     * @param Request $request
     * @return mixed
     */
    public function quota(Request $request)
    {
        $uid  = $request->id;
        $user = $this->userService->findId($uid);
        if( !$user || $user->group_type != 3){
            return ajaxError('无权获取');
        }

        return ajaxSuccess('获取成功',['quota'=>$user->quota]);
    }

    /**
     * 唯一验证
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkUnique(Request $request)
    {
        $result = $this->checkUniqueService->check('users', $request->type, $request->value, $request->id);

        if ($result) {
            return response()->json(array("valid" => "true"));
        } else {
            return response()->json(array("valid" => "false"));
        }
    }


}