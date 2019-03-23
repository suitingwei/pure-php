<?php
/**
 * Created by PhpStorm.
 * User: sui
 * Date: 2019/3/12
 * Time: 15:29
 */

/**
 * Class FindKthLargestProblem
 *
 * @link https://leetcode-cn.com/explore/interview/card/top-interview-quesitons-in-2018/266/heap-stack-queue/1154/
 */
class FindKthLargestProblem
{
    /**
     * @param Integer[] $nums
     * @param Integer   $k
     *
     * @return null
     */
    function findKthLargest($nums, $k)
    {
        return $this->quickSort($nums, $k, 0, count($nums) - 1);
    }
    
    /**
     * @param $arr
     * @param $k
     * @param $left
     * @param $right
     *
     * @return
     */
    private  function quickSort(&$arr, $k, $left, $right)
    {
        $pivot = $this->partition($arr, $left, $right);
        
        if ( ($pivot + 1) == $k) {
            return  $arr[$pivot];
        }
        
        if($pivot > $k -1 ){
            return $this->quickSort($arr,$k,$left,$pivot-1) ;
        }
        else{
            return $this->quickSort($arr,$k,$pivot+1,$right) ;
        }
    }
    
    private function partition(&$arr, $left, $right)
    {
        $k = $i = $left;
        
        $pivotValue = $arr[$right];
        
        for(;$i<$right;$i++){
           if($arr[$i] > $pivotValue) {
               $temp = $arr[$i];
               $arr[$i] = $arr[$k];
               $arr[$k++]= $temp;
           }
        }
        $arr[$i] = $arr[$k];
        $arr[$k] = $pivotValue;
    
        return $k;
    }
    
    
}

$nums= [3,2,1,5,6,4];$k = 1;
var_dump( (new FindKthLargestProblem())->findKthLargest($nums,$k));