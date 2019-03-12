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


/**
 * 依次比较每一个数字和他前面的数字，如果比他小，那么就交换这两个文职
 */
for ($i = 1; $i < count($arr); $i++) {
    //如果这个数字比他前面的书小
    if ($arr[$i] < $arr[$i - 1]) {
        $temp = $arr[$i];
        
        for ($j = $i - 1; $j >= 0 && $arr[$j] > $temp; $j--) {
            $arr[$j + 1] = $arr[$j];
        }
        $arr[$j + 1] = $temp;
    }
}
print_r($arr);

