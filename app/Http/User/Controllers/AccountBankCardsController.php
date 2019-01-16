<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/1/15
 * Time: 17:57
 */

namespace App\Http\User\Controllers;


use App\Services\AccountBankCardsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountBankCardsController extends Controller
{
    protected $accountBankCardsService;

    public function __construct(AccountBankCardsService $accountBankCardsService)
    {
        $this->accountBankCardsService=$accountBankCardsService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data = $request->input();
        $data['user_id'] = Auth::user()->id;

        $list = $this->accountBankCardsService->getAllPage($data, 6);
        return view("User.AccountPhone.bank", compact('list'));
    }

    /**
     * 添加
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
//        dd($request->input());
        $id = $request->id ?? '';

        if (!empty($id)) {
            $result = $this->accountBankCardsService->update($id, Auth::user()->id, $request->input());
            if ($result) {
                return ajaxSuccess('编辑成功！');
            } else {
                return ajaxError('编辑失败！');
            }
        } else {
            $request->merge(['user_id' => auth()->user()->id]);
            $result = $this->accountBankCardsService->add($request->input());
            if ($result) {
                return ajaxSuccess('账号添加成功！');
            } else {
                return ajaxError('账号添加失败！');
            }
        }

    }


    /**
     * 编辑
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Request $request)
    {
        $result = $this->accountBankCardsService->findIdAndUserId($request->id, Auth::user()->id);
        if ($result) {
            return ajaxSuccess('获取成功！', $result->toArray());
        } else {
            return ajaxError('获取失败！');
        }
    }

}