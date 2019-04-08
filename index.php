<?php

require __DIR__ . '/vendor/autoload.php';




$nums = [0,0,2,3];

function dominantIndex($nums) {
    $max = PHP_INT_MIN;
    $secondMax = PHP_INT_MIN;
    $maxIndex= -1;
    
    
    for($i=0;$i<count($nums);$i++){
        if($nums[$i] > $max){
            $secondMax = $max;
            $max = $nums[$i];
            $maxIndex = $i;
        }elseif($nums[$i] > $secondMax){
            $secondMax = $nums[$i];
        }
    }
    echo "Max:{$max},SecondMax:{$secondMax}\n";
    if( ($max /2) >= $secondMax){
        return $maxIndex;
    }
    return -1;
}


dominantIndex($nums);
