<?php
/**
 * 自定义函数
 * Created by PhpStorm.
 * User: Admin
 * Date: 2018/10/31
 * Time: 10:59
 */

/**
 * @param string $msg
 * @param array $data
 * @param int $httpCode
 * @return \Illuminate\Http\JsonResponse
 */
function ajaxSuccess(string $msg = 'success', array $data = [], int $httpCode = 200)
{
    $return = [
        'status' => 1,
        'msg'    => $msg,
        'data'   => $data,
    ];
    return response()->json($return, $httpCode);
}

/**
 * @param string $errMsg
 * @param int $httpCode
 * @return \Illuminate\Http\JsonResponse
 */
function ajaxError(string $errMsg = 'error' ,int $httpCode = 200)
{
    $return = [
        'status' => 0,
        'msg'    => $errMsg
    ];
    return response()->json($return, $httpCode);
}

/**
 * @param $data
 * @param string $lefthtml
 * @param int $pid
 * @param int $lvl
 * @return array
 */
function tree($data , $lefthtml = '|— ' , $pid=0 , $lvl=1)
{
    $arr = [];
    foreach ($data as $k => $v) {
        if ($v['pid'] == $pid) {
            $v['ltitle'] = str_repeat($lefthtml, $lvl) . $v['title'];
            $arr[] = $v;
            unset($data[$k]);
            $arr = array_merge($arr, tree($data, $lefthtml, $v['id'], $lvl + 1));
        }
    }
    return $arr;
}

/**
 * @param array $data
 * @param array $checked
 * @param int $pid
 * @return array
 */
function ztreeData(array $data, array $checked, int $pid = 0)
{
    $arr = [];
    foreach ($data as $k => $v) {
        if ($v['pid'] == $pid) {
            if (in_array($v['id'], $checked)) {
                $v['checked'] = true;
            }
            $v['open'] = true;
            $arr[] = $v;
            unset($data[$k]);
            $arr = array_merge($arr, ztreeData($data, $checked, $v['id']));
        }
    }
    return $arr;
}

/**
 * 订单id
 * @return string
 */
function getOrderId()
{
    $uniQid    = uniqid('', true);
    $subUniQid = substr($uniQid, 7, 17);
    $strSplit  = str_split($subUniQid, 1);
    $arrayMap  = array_map('ord', $strSplit);
    $str = substr(implode(NULL, $arrayMap), 0, 6);
    return date('YmdHis') . $str;
}

/**
 * 生成随机位数的字符串
 * @param int $length
 * @return string
 */
function randomStr( int $length = 16)
{
    $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
    $str = "";
    for ($i = 0; $i < $length; $i++) {
        $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
    }
    return $str;
}

/**
 * 生成商户号
 * @param int $id
 * @return string
 */
function getMerchant(int $id){

    $year    = date('y',time());
    $week    = date('W',time());
    $weekDay = date("w",time());
    $str     = $year.$week.$weekDay.$id;
    $randStr = mt_rand(str_pad(0,10-strlen($str),0),str_pad(9,10-strlen($str),9));
    return $str.$randStr;
}