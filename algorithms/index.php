<?php

function moveZeroes(&$nums) {
        //类似于冒泡的流程，从前到后遍历，不过这次遍历也是用双指针，一个指针找0，一个指针找非0元素。然后交换这两个 index。
        $i = $j = 0;
        $length = count($nums);
        
        while( ($i < $length) && ($j < $length) ){
			 echo sprintf("i=%s,j=%s\n",$i,$j);
             //查找为0元素位置
             if($nums[$i] !=0 ){
                 $i++;
             }
             
             //查找非0元素位置
             if($nums[$j] == 0 ){
                 $j++;
             }
             
             if( ($i < $j) && ($i< $length) && ($j<$length)){
                //交换两个位置
                $temp = $nums[$i];
                $nums[$i] = $nums[$j];
                $nums[$j] = $temp;
                $i ++ ;
                $j++;
             }
        }
    }
$arr=[1,0];
moveZeroes($arr);
print_t($arr);
