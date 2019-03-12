<?php
/**
 * Created by PhpStorm.
 * User: sui
 * Date: 2019/3/11
 * Time: 23:20
 */

class MergeSort
{
    //归并算法总函数
    function slove(array $arr)
    {
        $this->mSort($arr, 0, count($arr));
        return $arr;
    }

    function mSort(array $arr, $start, $end)
    {
        //当子序列长度为1时，$start == $end，不用再分组
        if ($start >= $end) {
            return [];
        }
        $mid = intval(($start + $end) / 2);    //将 $arr 平分为 $arr[$start - $mid] 和 $arr[$mid+1 - $end]
        $arr1 = $this->mSort($arr, $start, $mid-1);            //将 $arr[$start - $mid] 归并为有序的$arr[$start - $mid]
        $arr2=  $this->mSort($arr, $mid , $end-1);            //将 $arr[$mid+1 - $end] 归并为有序的 $arr[$mid+1 - $end]
        return $this->mergeArray2($arr1,$arr2);       //将$arr[$start - $mid]部分和$arr[$mid+1 - $end]部分合并起来成为有序的$arr[$start - $end]
    }

    //归并操作
    function mergeArray(array &$arr, $start, $mid, $end)
    {
        $i       = $start;
        $j       = $mid + 1;
        $k       = $start;
        $temparr = [];

        while ($i != $mid + 1 && $j != $end + 1) {
            if ($arr[$i] >= $arr[$j]) {
                $temparr[$k++] = $arr[$j++];
            } else {
                $temparr[$k++] = $arr[$i++];
            }
        }

        //将第一个子序列的剩余部分添加到已经排好序的 $temparr 数组中
        while ($i != $mid + 1) {
            $temparr[$k++] = $arr[$i++];
        }
        //将第二个子序列的剩余部分添加到已经排好序的 $temparr 数组中
        while ($j != $end + 1) {
            $temparr[$k++] = $arr[$j++];
        }
        for ($i = $start; $i <= $end; $i++) {
            $arr[$i] = $temparr[$i];
        }
    }

    private function mergeArray2(array $arr1, array $arr2)
    {
    }
}


$arr = range(5, 20);
shuffle($arr);
print_r((new MergeSort())->slove($arr));