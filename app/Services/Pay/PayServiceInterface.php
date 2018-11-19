<?php

namespace App\Services\Pay;
use App\Exceptions\CustomServiceException;

abstract class PayServiceInterface
{

    /**
     * http post 表单提交
     * @param string $url
     * @param array $data
     */
    protected function sendHttpPost(string $url, array $data)
    {
        $str = '<form id="Form1" name="Form1" method="post" action="' . $url . '" >';
        foreach ($data as $key => $val) {
            $str .= '<input type="hidden" name="' . $key . '" value="' . $val . '">';
        }
        $str .= '</form>';
        $str .= '<script>';
        $str .= 'document.Form1.submit();';
        $str .= '</script>';
        exit();
    }

    /**
     * Curl 提交
     * @param $url
     * @param null $data
     * @param null $header
     * @param null $referer
     * @return mixed
     */
    protected function sendCurl($url, $data = null, $header = null, $referer = null)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_URL, $url);

        if ($header) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }
        if ($referer) {
            curl_setopt($ch, CURLOPT_REFERER, $referer);
        }
        if ($data) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        } else {
            curl_setopt($ch, CURLOPT_POST, false);
        }
        if (stripos($url, 'https://') !== false) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);   // 跳过证书检查
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);   // 从证书中检查SSL加密算法是否存在
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        if ( $res = curl_exec($ch) === false) {

            throw new CustomServiceException(sprintf('Curl error (code %s): %s', curl_errno($ch), curl_error($ch)));
        }
        curl_close($ch);
        return $res;
    }

}