<?php
/**
 * Created by PhpStorm.
 * User: sui
 * Date: 2019/3/21
 * Time: 17:40
 */

class RestoreIpAddressProblem
{
    /**
     * @param String $s
     *
     * @return String[]
     */
    function restoreIpAddresses($s)
    {
        if (empty($s)) {
            return [];
        }
        
        $result = [];
        
        $length = strlen($s);
        
        $this->try($s, $length, 0, $result, "");
        
        return $result;
    }
    
    /**
     * @param  string $s          用于恢复的字符串
     * @param  int    $length     整个字符串的长度
     * @param  int    $startIndex 当前这一轮分割操作的起始下标
     * @param  array  &$result    整个结果集
     * @param  "" $tempResult 临时结果集
     * @param int     $times      已经分割的次数
     */
    function try($s, $length, $startIndex, &$result, $tempResult, $times = 0)
    {
        if ($times ==3 ){
            $leftSegment = (substr($s,$startIndex));
            if($leftSegment === false || $leftSegment === ""||  $leftSegment < 0 || $leftSegment > 255){
                return;
            }
            if(strlen($leftSegment) > 1 && $leftSegment[0] =='0'){
                return;
            }
            $tempResult.=$leftSegment;
    
            if(!isset($result[$tempResult])){
                $result[$tempResult] = $tempResult;
            }
            
            return;
        }
        
        //这里第一版本计算的用平均长度来算，比如一个长度=9的字符串，那么分割成为4个段，每一段至少是9/4 =2 长度
        //$averageLength = floor($length /4);
        
        //从startIndex这个位置，尝试往后截取某个长度的字符串，作为这一段的 ip 地址。当然还需要校验 ip 的合法性，0~255
        //当然每次最多只能截取3位长度的字符串
        for ($i = 1; $i <= 3; $i++) {
            //尝试截取这一段的 ip
            $segment = (substr($s, $startIndex, $i));
            
            if ( $segment < 0 || $segment > 255) {
                continue;
            }
            
            if(strlen($segment) > 1 && $segment[0] =='0'){
                continue;
            }
            
            $tempResult.= $segment.".";
            
            $this->try($s,$length, $startIndex + $i, $result, $tempResult, $times + 1);
            
            $tempResult = substr($tempResult,0,- (strlen($segment)+1));
        }
        
        
        return;
    }
}


print_r( (new RestoreIpAddressProblem())->restoreIpAddresses("172162541"));