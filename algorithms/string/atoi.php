<?php
/**
 * Created by PhpStorm.
 * User: sui
 * Date: 2019/3/1
 * Time: 15:26
 */
class Solution {
    
    
    /**
     * @param String $str
     * @return Integer
     */
    function myAtoi($str) {
        
        $i = 0;
        
        $length = strlen($str);
        
        if(empty($str))
        {
            return 0;
        }
        
        //过滤空格
        while($i < $length && $str[$i] == ' ' )
        {
            $i++;
        }
        
        //如果是第一个非空的是字母，那么就返回0
        if(ctype_alpha($str[$i])){
            return 0;
        }
    
        $sign   = 1 ;
        //判断是不是负号
        if($str[$i] == '-'){
            $sign = -1;
            $i++;
        }
        
        

        $result = "";
        while($i<$length){
            
            if(!is_numeric($str[$i])){
                break;
            }else{
                $result .=$str[$i];
                $i++;
            }
            
        }
        $result = $sign * floatval($result);
        
        if($result > 0 ){
            return $result > pow(2,31) -1 ? pow(2,31)-1 :$result;
        }
        else{
            return $result < - pow(2,31) ? -pow(2,31) : $result;
        }
        
        
    }
}
echo (new Solution())->myAtoi("    -");