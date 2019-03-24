<?php
/**
 * Created by PhpStorm.
 * User: sui
 * Date: 2019-03-23
 * Time: 22:16
 */

class SubSetProblemII
{
    /**
     * @param Integer[] $nums
     * @return Integer[][]
     */
    function subsets($nums)
    {
        $result = [];
        $length = count($nums);

        sort($nums);
        $this->solve($nums, $length, $result);

        return $result;
    }

    /**
     * @param $nums
     * @param $length
     * @param $result
     */
    function solve($nums, $length, &$result)
    {
        //凑出来指定长度的子集
        for ($targetLength = 0; $targetLength <= $length; $targetLength++) {
            $this->try($nums, $targetLength, 0, $result, []);
        }
        return;
    }

    /**
     * 计算指定长度的子集
     * @param int[]   $nums         数组
     * @param int     $targetLength 指定目标集长度
     * @param int     $startIndex   从数组中哪一个 index 开始截取元素
     * @param int[][] $result       结果集
     * @param int[]   $tempResult   临时结果集，存储这一次的结果
     */
    function try($nums, $targetLength, $startIndex, &$result, $tempResult)
    {
        //如果这一次临时结果的长度已经合法，加入最终结果
        if ($targetLength == count($tempResult)) {
            $result [] = $tempResult;
            return;
        }
        //因为备选数组是排序的，所以为了避免重复生成子集，我们每次都往后挪动 index
        for ($i = $startIndex; $i < count($nums); $i++) {
            if($i>0 && $nums[$i] == $nums[$i-1] && $i>$startIndex){
                continue;
            }
            $tempResult [] = $nums[$i];

            $this->try($nums, $targetLength, $i + 1, $result, $tempResult);

            array_pop($tempResult);
        }
        return;
    }
}

$nums     = [1, 2, 2,3,3];
$solution = new SubSetProblemII();
$result   = $solution->subsets($nums);
//$solution->try($nums, 3,0, $result, []);
print_r($result);