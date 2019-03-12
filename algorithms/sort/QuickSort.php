<?php
/**
 * Created by PhpStorm.
 * User: sui
 * Date: 2019/3/12
 * Time: 10:55
 */

class QuickSort
{
    function partion(&$arr, $left, $right)
    {
        $pivot = $arr[$right];
        $k     = $i = $left;
        for (; $i < $right; $i++) {
            if ($arr[$i] < $pivot) {
                $temp      = $arr[$i];
                $arr[$i]   = $arr[$k];
                $arr[$k++] = $temp;
            }
        }
        //这一步很重要，因为在i结束循环的时候，正好指向了最后一个元素，而 k 指向的是最后一个大于pivot的元素位置
        //将他们交换即可
        $arr[$i] = $arr[$k];
        $arr[$k] = $pivot;
        
        echo "Pivot:{$pivot},K:{$k},Arr:" . json_encode($arr) . PHP_EOL;
        
        return $k;
    }
    
    function quick_Sort(&$arr, $left, $right)
    {
        if ($left >= $right) {
            return;
        }
        
        $pivot = $this->partion($arr, $left, $right);
        
        //注意，这里递归调用的时候，因为第pivot个位置已经 fix 了，所以要略过他
        $this->quick_Sort($arr, $left, $pivot - 1);
        $this->quick_Sort($arr, $pivot + 1, $right);
    }
    
    function slove($arr)
    {
        $this->quick_Sort($arr, 0, count($arr) - 1);
        
        return $arr;
    }
}

//$arr = range(1, 15);
//shuffle($arr);
$arr = [5, 7, 1, 2, 6, 4];
print_r((new QuickSort())->slove($arr));