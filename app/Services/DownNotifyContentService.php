<?php

namespace App\Services;


use Illuminate\Support\Facades\Log;

class DownNotifyContentService{

    public function send()
    {
        $data['t']= 'ok';
        $result = sendCurl('http://cc.vovpay.com/Pay_Exemption_test.html',$data);
        Log::info('order async notify echo info:', ['content' => strtolower($result)]);
        if(strtolower($result) === 'ok'){
            return true;
        }else{
            return false;
        }
    }
}