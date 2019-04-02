<?php
/**
 * Created by PhpStorm.
 * User: sui
 * Date: 2019/3/29
 * Time: 17:41
 */

class LongestIncreasingSequenceProblem
{
    /**
     * @param Integer[] $nums
     * @return Integer
     */
    function lengthOfLIS($nums) {
        if(empty($nums)){
            return 0 ;
        }
        /**
         * 假设dp[i] 是到 i为止的最长上升序列,那么dp[i]= dp[i],dp[i-1]
         * @var array
         */
        $dp = array_fill(0,count($nums),1);
        $max= 1;
        for($i=0;$i<count($nums);$i++){
            for($j=0;$j<$i;$j++){
                //如果当前遍历的这个数字比他前面的这个数大，那么看一下当前这个数跟之前的连续上升序列拼接有多长
                if($nums[$i] > $nums[$j]){
                    $dp[$i] = max($dp[$i],$dp[$j]+1);
                }
            }
            $max=  max($max,$dp[$i]);
        }
        return $max;
    }
}
$solution = new LongestIncreasingSequenceProblem();
$nums =[10,9,2,5,3,7,101,18];
$result = $solution->lengthOfLIS($nums);
var_dump($result);