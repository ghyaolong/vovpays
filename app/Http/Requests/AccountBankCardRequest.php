<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AccountBankCardRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        /*
         * #挂号方式:1商户后台挂号,2总后台挂号,3代理后台挂号,4三方挂号
         */
        if ($this->id){
            //更新操作
            $user_id = env('ADD_ACCOUNT_TYPE')!=2?Auth::user()->id:100000;
            $device_id = $this->id;
            $deviceInfo = DB::table('account_bank_cards')->whereId($device_id)->whereUserId($user_id)->first();
            if(!$deviceInfo){
                throw new CustomServiceException('非法操作!');
            }
            return true;
        }else{
            //添加操作
            $add_account_type=env('ADD_ACCOUNT_TYPE');
            $userType=Auth::user()->group_type??null;
            if($add_account_type==1&&$userType==1)      return  true;
            if($add_account_type==2&&$userType==null)   return  true;
            if($add_account_type==3&&$userType==2)      return  true;
            if($add_account_type==4&&$userType==3)      return  true;
            throw new CustomServiceException('非法操作!');
        }


    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->id ?? '';

        return [
            'bank_account'  => 'required_without:status',
            'qrcode'        => 'nullable|unique:account_bank_cards,qrcode,' . $id,
            'phone_id'      => 'required_without:status|alpha_num',
            'dayQuota'      => 'required_without:status|numeric',
            'bank_name'     => 'required_without:status',
            'cardNo'        => 'required_without:status|unique:account_bank_cards,bank_account,' . $id,
            'chard_index'   => 'nullable|alpha_num',
            'id'            => 'nullable|numeric',
            'status'        => 'nullable|in:true,false',
        ];
    }

    public function messages()
    {
        return [
            'bank_account.unique' => '账号已存在',
            'qrcode.unique' => '收款码已存在',
            'qrcode.regex' => '收款码格式错误',
            'phone_id.alpha_num' => '手机标识格式错误',
            'dayQuota.numeric' => '账号限额必须为整数',
            'cardNo.unique' => '银行账号已存在',
            'chard_index.alpha_num' => '索引格式错误',
            'id.numeric' => '非法操作',
            'status.in' => '非法操作',
        ];
    }
}
