<?php
/**
 * Created by PhpStorm.
 * User: sui
 * Date: 2019/3/9
 * Time: 13:32
 */

/**
 * Class FindDuplicates
 * @link https://leetcode-cn.com/problems/find-all-duplicates-in-an-array/
 */
class FindDuplicates
{
    /**
     * 不适用额外存储空间，O(n)时间复杂度
     * @param Integer[] $nums
     * @return Integer[]
     */
    function solution($nums)
    {
        $duplicates = [];
        /**
         * 假如这个数组没有重复，那么数组元素应该正好是从1~N位置，长度也是 N.但是现在有了重复的元素，所以位置是错乱的。
         * 那么这个算法的思想就是把第i个位置应该有的元素放过去。比如$arr[0] 应该是1=(0+1), $arr[2] 应该是3=(2+1)。
         * 如果$arr[i]个位置的值不是其应该有的值(i+1),而是m，那么我们就把 m 这个元素交换到$arr[m-1]去。如果
         * $arr[m-1]的元素正好是$arr[i]应该有的值:i+1,那么就结束了。如果不是，那么继续循环。
         */
        for ($i = 0; $i < count($nums); $i++) {
            //如果这个数字的位置不是应该有的i+1
            while ($nums[$i] != ($i + 1)) {
                //$arr[i]保存的值m,是第m-1个索引的位置
                $nextIndex = $nums[$i] - 1;

                $temp = $nums[$nextIndex];
                if ($temp == $nums[$i]) {
                    if (!in_array($temp, $duplicates)) {
                        $duplicates [] = $temp;
                    }
                    continue 2;
                }
                $nums[$nextIndex] = $nums[$i];
                $nums[$i]         = $temp;
            }
        }

        return $duplicates;
    }

    /**
     * 取负法
     * @param $nums
     * @return array
     */
    function solution2($nums)
    {
        $result = [];
        for ($i = 0; $i < count($nums); $i++) {
            $m = abs($nums[$i]) - 1;
            if ($nums[$m] > 0) {
                $nums[$m] = -$nums[$m];
            } else {
                $result [] = ($m + 1);
            }
        }
        return $result;
    }
}

$nums = [4, 3, 2, 7, 8, 2, 3, 1];
print_r((new FindDuplicates())->solution($nums));
