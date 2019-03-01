<?php
/**
 * Created by PhpStorm.
 * User: sui
 * Date: 2019/2/28
 * Time: 19:34
 */
$str=  "hello";
function reverseString(&$s) {
    $i = 0;
    $j = strlen($s)-1;
    
    
    while($i < $j ){
        $temp = $s[$i];
        $s[$i]= $s[$j];
        $s[$j] =$temp;
        
        $i++;
        $j--;
    }
    
    return;
}

reverseString($str);
echo $str;