<?php

namespace App\Http\Pay\Controllers;

use Illuminate\Http\Request;
use App\Common\RespCode;
use App\Services\AesService;

class PayController extends Controller
{

    protected $aesService;
    protected $_AES;
    protected $return_type; // 返回类型true:json，false:页面
    protected $header_Content_type = 'application/json'; //上传类型
    protected $content;

    public function __construct(AESService $aesService)
    {
        parent::__construct();
        $this->aesService = $aesService;
        $this->_AES = env('PAY_KEY');
    }

    public function index(Request $request)
    {
        if( isset($request->json) && $request->json == 'json'){
            $this->return_type = true;
        }else{
            $this->return_type = false;
        }

        if($request->header('Content-Type') != $this->header_Content_type)
        {
            return ajaxError('请使用正确的提交格式：application/json');
        }

        if(!$request->getContent())
        {
            return json_encode(RespCode::PARAMETER_ERROR);
        }

        $this->content = json_decode($request->getContent(),true);


//        "{'cipherData':'R4YuWygi/yWivAtmCwrsyDOMteNxbls4OHQ3/h+xjOAn9DPnC4PUvlf7PCy0HpHomyrKHrk0cnAjp0MZRvzAh5SLBZxIo7Y3/Y+Aq7xryjOgpumPoducA95mZqf9UXTlRDj0DQTpjUFv3NFM3p0d7Q9wZmmVbuVYV4BdgF4g9IS0CA4NjY1ph0VHpoOb2dCnxj/3T06x/JcqMQzRzExIg69tqXsnpUgE8SM7wY2PMvheCd8tPVuV4bDYtWbNrgtCOVAdpYj6JQgl84CT480y+aad5o9CsdyVPrrf/hFPHVA='}"

        return json_encode($this->content);
    }

    public function orderAddJson(){

        return '返回json';
    }
}
