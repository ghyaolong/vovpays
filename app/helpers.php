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