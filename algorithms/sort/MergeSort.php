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
        if($start < $end){
            $mid = floor(($start + $end) / 2);    //将 $arr 平分为 $arr[$start - $mid] 和 $arr[$mid+1 - $end]
            $this->mSort($arr, $start, $mid);            //将 $arr[$start - $mid] 归并为有序的$arr[$start - $mid]
            $this->mSort($arr, $mid+1 , $end);            //将 $arr[$mid+1 - $end] 归并为有序的 $arr[$mid+1 - $end]
            $this->mergeArray($arr,$start,$mid,$end);//将$arr[$start - $mid]部分和$arr[$mid+1 - $end]部分合并起来成为有序的$arr[$start - $end]
        }
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

}


$arr = range(5, 20);
shuffle($arr);
print_r((new MergeSort())->slove($arr));