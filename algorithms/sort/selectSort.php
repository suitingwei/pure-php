<?php
/**
 * Created by PhpStorm.
 * User: sui
 * Date: 2019/1/14
 * Time: 19:26
 */

$arr = range(1, 100);
shuffle($arr);

print_r($arr);


for ($i = 0; $i < count($arr) - 1; $i++) {
    $min    = $arr[$i];
    $minPos = $i;
    
    for ($j=$i+1; $j < count($arr); $j++) {
        if ($arr[$j] < $min) {
            $min = $arr[$j];
            $minPos = $j;
        }
    }
    if($minPos != $j){
        $temp = $arr[$minPos];
        $arr[$minPos] = $arr[$i];
        $arr[$i] = $temp;
    }
}
print_r($arr);

