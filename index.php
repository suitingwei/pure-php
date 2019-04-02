<?php

require __DIR__ . '/vendor/autoload.php';



foreach (range(1,100) as $current){
    list($times,$selectedRound) = calculateRound(1, $current, [30, 20]);

    echo sprintf("当前值:%s，在第%s次完整周期后，在%s区间中\n",$current,$times,$selectedRound);
}


function calculateRound($start, $current, array $rounds)
{
    $roundSum = array_sum($rounds);
    
    $gap = $current - $start;
    
    //计算在第几个周期
    $times = intval($gap / $roundSum);
    
    //对整个大周期取余
    $current = $current % $roundSum;
    
    $selectedRound = 0;
    
    foreach ($rounds as $round) {
        if ($current > $round) {
            $current -= $round;
        } else {
            $selectedRound = $round;
            break;
        }
    }
    return [$times+1,$selectedRound];
}
