<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Exceptions\CustomServiceException;

class AccountPhoneStatusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user_id = Auth::user()->id;
        $device_id = $this->id;
        $deviceInfo = DB::table('account_phones')->whereId($device_id)->whereUserId($user_id)->first();

        if(!$deviceInfo){
            throw new CustomServiceException('非法操作!');
        }
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'id' => 'required|numeric',
            'status' => 'required|in:true,false',
        ];
    }

    public function messages()
    {
        return [
            'id.required' => '非法操作',
            'id.numeric' => '非法操作',
            'status.required' => '非法操作1',
            'status.in' => '非法操作2',
        ];
    }
}
