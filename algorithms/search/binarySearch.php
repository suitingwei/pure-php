<?php

/**
 * Created by PhpStorm.
 * User: sui
 * Date: 2019/3/4
 * Time: 16:34
 */
class Solution
{
    function binarySearchRecursive(array $array, $value, $start, $end)
    {
        $middle  = $start + intval(($end - $start) / 2);
        $element = $array[$middle];

        if ($start > $end) {
            return -1;
        }
        if ($element == $value) {
            return $middle;
        }
        
        //如果目标元素大于中间值，那么证明目标值在右边
        if ($value > $element) {
            return $this->binarySearchRecursive($array, $value, $middle + 1, $end);
        } else {
            return $this->binarySearchRecursive($array, $value, $start, $middle - 1);
        }
    }
    
    function binarySearch(array $array,$value){
       $left = 0;
       $right = count($array)-1;
       
       while($left <= $right){
           $middle = $left + intval(($right-$left)/2);
           if($array[$middle] == $value){
               return $middle;
           }
           if($value > $array[$middle]){
               $left = $middle +1;
           }else{
               $right =$middle -1;
           }
       }
    }
    
}

$arr = range(1, 1000);

echo (new Solution())->binarySearchRecursive($arr, 68, 0, count($arr) - 1);
echo (new Solution())->binarySearch($arr, 68);
