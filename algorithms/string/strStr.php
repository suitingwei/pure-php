<?php
/**
 * Created by PhpStorm.
 * User: sui
 * Date: 2019/3/1
 * Time: 11:54
 */
class Solution {
    
    /**
     * @param String $haystack
     * @param String $needle
     * @return Integer
     */
    function strStr($haystack, $needle) {
        
        if(empty($needle) ){
            return 0;
        }
        
        
        $needleLength =strlen($needle);
        
        for($i=0;$i<strlen($haystack);$i++){
            //如果不相同，那么大数组往后遍历
            if($haystack[$i] != $needle[0]){
                continue;
            }
            //如果大数组相同了，开始看小数组能不能相同
            else{
                for($k=0;$k< $needleLength; $k++){
                    if($needle[$k] != $haystack[$i+$k]){
                        continue 2;
                    }
                }
                return $i;
            }
        }
        return -1;
    }
}


$haystack= "mississippi";
$needle =  "issi";
echo (new Solution())->strStr($haystack,$needle);