<?php
/**
 * Created by PhpStorm.
 * User: sui
 * Date: 2019/1/14
 * Time: 19:26
 */

$arr = range(1,100);
shuffle($arr);

print_r($arr);

for ($i=0;$i<count($arr);$i++){
    for ($j=$i;$j<count($arr);$j++){
        if($arr[$i] > $arr[$j]){
            $temp = $arr[$j];
            $arr[$j] = $arr[$i];
            $arr[$i] = $temp;
        }
    }
}
print_r($arr);

