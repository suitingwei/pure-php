<?php
/**
 * Created by PhpStorm.
 * User: sui
 * Date: 2019/3/6
 * Time: 22:32
 */

/**
 * Class SearchRotateArray
 * @link https://leetcode-cn.com/problems/search-in-rotated-sorted-array/
 */
class SearchRotateArray
{
    function search(array $nums, int $target)
    {
        $left  = 0;
        $right = count($nums) - 1;

        while ($left <= $right) {
            $middle = $left + intval(($right - $left) / 2);

            echo sprintf("L[%s]=%s,\tM[%s]=%s,\tR[%s]=%s\n",
                $left, $nums[$left], $middle, $nums[$middle],$right, $nums[$right]);

            if ($nums[$middle] == $target) {
                return $middle;
            }

            //如果左侧是连续递增的
            if($nums[$middle] >= $nums[$left]){
                //在连续区间内
                if($target >= $nums[$left] && $target < $nums[$middle]){
                   $right = $middle-1;
                }
                else{
                    $left = $middle +1;
                }
            }

            //如果右侧是连续的
            if($nums[$middle] < $nums[$right]){
                //在连续区间内
                if($target <= $nums[$right] && $target > $nums[$middle]){
                    $left= $middle + 1;
                }
                else{
                    $right= $middle - 1;
                }
            }


        }
        return -1;
    }
}

$nums   = [4, 5, 6, 7, 8, 1, 2, 3];
$target = -1;
var_dump((new SearchRotateArray())->search($nums, $target));

/**
 *
  [4,5,6,7, 0,1,2]
 * 1) left = 0 ,right=6, middle=3,
 *
 */
