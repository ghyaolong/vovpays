<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/1/15
 * Time: 17:57
 */

namespace App\Http\Agent\Controllers;

use App\Services\AccountBankCardsService;
use App\Services\AccountPhoneService;
use App\Services\BanksService;
use App\Services\CheckUniqueService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\DelPhoneRedisService;

class AccountBankCardsController extends Controller
{
    protected $accountBankCardsService;
    protected $accountPhoneService;
    protected $checkUniqueService;
    protected $banksService;

    public function __construct(BanksService $banksService, AccountBankCardsService $accountBankCardsService, CheckUniqueService $checkUniqueService,AccountPhoneService $accountPhoneService)
    {
        $this->accountBankCardsService=$accountBankCardsService;
        $this->accountPhoneService = $accountPhoneService;
        $this->checkUniqueService = $checkUniqueService;
        $this->banksService=$banksService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $title='银行卡号';
        $data = $request->input();
        $data['user_id'] = Auth::user()->id;

        $list = $this->accountBankCardsService->getAllPage($data, 10);
        $data['accountType'] = 'alipay';
        $bankList=$this->banksService->findAll();

        $module='Agent';
        $query = $request->query();
        return view("Common.bank", compact('list', 'bankList','module','query'));

    }

    /**
     * 添加
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $id = $request->id ?? '';
        $this->validate($request, [
            'cardNo'        => 'required|unique:account_bank_cards,cardNo,'.$id,
        ],[
            'cardNo.unique'           => '卡号已存在',
        ]);

        if (!empty($id)) {
            $result = $this->accountBankCardsService->update($id, Auth::user()->id, $request->input());
            if ($result) {
                return ajaxSuccess('编辑成功！');
            } else {
                return ajaxError('编辑失败！');
            }
        } else {

            $request->merge(['user_id' => Auth::user()->id]);
            $result = $this->accountBankCardsService->add($request->input());
            if ($result) {
                return ajaxSuccess('账号添加成功！');
            } else {
                return ajaxError('账号添加失败！');
            }
        }

    }

    /**
     * 编辑状态
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveStatus(Request $request)
    {
        $data['status'] = $request->status == 'true' ? '1' : '0';
        $result = $this->accountBankCardsService->update($request->id, auth()->user()->id, $data);
        if ($result) {
            return ajaxSuccess('修改成功！');
        } else {
            return ajaxError('修改失败！');
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

    /**
     * 删除
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request)
    {
        $accountBankCards = $this->accountBankCardsService->findIdAndUserId($request->id, auth()->user()->id);
        $result = $this->accountBankCardsService->del($request->id, auth()->user()->id);
        if ($result) {
            if($accountBankCards)
            {
                $delPhoneRedisService = app(DelPhoneRedisService::class);
                $delPhoneRedisService->del($accountBankCards->phone_id,$accountBankCards->accountType);
            }
            return ajaxSuccess('账号已删除！');
        } else {
            return ajaxError('删除失败！');
        }
    }

    /**
     * 检测唯一性
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkUnique(Request $request)
    {
        $result = $this->checkUniqueService->check('account_bank_cards', $request->type, $request->value, $request->id, $request->name);
        if ($result) {
            return response()->json(array("valid" => "true"));
        } else {
            return response()->json(array("valid" => "false"));
        }
    }

}