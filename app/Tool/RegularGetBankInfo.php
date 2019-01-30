<?php

namespace App\Tool;

/**
 * 根据传入的银行编号，提取金额
 * Class RegularGetBankInfo
 * @package App\Tool
 */
class RegularGetBankInfo
{

    /**
     * 提取银行金额
     * @param string $number
     * @param string $content
     * @return string
     */
    public function getAmount(string $number, string $content){
        $content = str_replace(',','',$content);
        $content = str_replace('，','',$content);
        $amount = '0.00';
        switch ($number){
            case "95588"://中国工商银行
                preg_match('/\)(\d+|,\d{3})+(\.\d{0,4})?元/',$content,$matches);
                if(count($matches) == 2){
                    $amount = $matches[1];
                }else if(count($matches) == 3){
                    $amount = $matches[1].$matches[2];
                }

                break;
            case "95533"://中国建设银行
                preg_match('/人民币(\d+|,\d{3})+(\.\d{0,4})?元/',$content,$matches);
                if(count($matches) == 2){
                    $amount = $matches[1];
                }else if(count($matches) == 3){
                    $amount = $matches[1].$matches[2];
                }
                break;
            case "95599"://中国农业银行
                preg_match('/人民币(\d+|,\d{3})+(\.\d{0,4})?/',$content,$matches);
                if(count($matches) == 2){
                    $amount = $matches[1];
                }else if(count($matches) == 3){
                    $amount = $matches[1].$matches[2];
                }
                break;
            case "95555"://招商银行
                preg_match('/人民币(\d+|,\d{3})+(\.\d{0,4})?/',$content,$matches);
                if(count($matches) == 2){
                    $amount = $matches[1];
                }else if(count($matches) == 3){
                    $amount = $matches[1].$matches[2];
                }
                break;
            case "95561"://兴业银行
                preg_match('/收入(\d+|,\d{3})+(\.\d{0,4})?元/',$content,$matches);
                if(count($matches) == 2){
                    $amount = $matches[1];
                }else if(count($matches) == 3){
                    $amount = $matches[1].$matches[2];
                }
                break;
            default:
                return $amount;
        }
        return $amount;
    }

    /**
     * 提取银行卡尾号
     * @param string $number
     * @param string $content
     * @return string
     */
    public function getCardNo(string $number, string $content){
        $cardNo = '';
        switch ($number){
            case "95588"://中国工商银行
                preg_match('/尾号([\d]{4})卡/',$content,$matches);
                $cardNo =  sprintf("%.2f", $matches[1]);
                break;
            case "95533"://中国建设银行
                preg_match('/尾号([\d]{4})的/',$content,$matches);
                $cardNo = $matches[1];
                break;
            case "95599"://中国农业银行
                preg_match('/尾号([\d]{4})账户/',$content,$matches);
                $cardNo = $matches[1];
                break;
            case "95555"://招商银行
                preg_match('/人民币(\d+|,\d{3})+(\.\d{0,4})?/',$content,$matches);
                $cardNo = $matches[1];
                break;
            case "95561"://兴业银行
                preg_match('/账户\*([\d]{4})\*/',$content,$matches);
                $cardNo = $matches[1];
                break;
            default:
                return $cardNo;
        }
        return $cardNo;
    }
}