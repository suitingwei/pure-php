<?php
/**
 * Created by PhpStorm.
 * User: sui
 * Date: 2019/3/6
 * Time: 10:07
 */

class PermuteProblem
{
    function solve(array &$result, array $tempResult, array $nums, $usedIndex= [])
    {
        $length = count($nums);
        if (count($tempResult) == $length) {
            echo "Generated complete:" . json_encode($tempResult) . PHP_EOL;
            $result [] = $tempResult;
            
            return;
        }
        
        for ($i = 0; $i < $length; $i++) {
            if(in_array($i,$usedIndex)){
                continue;
            }
            $tempResult[] = $nums[$i];
            $usedIndex [] = $i;
            $this->solve($result, $tempResult, $nums, $usedIndex);
            array_pop($usedIndex);
            array_pop($tempResult);
        }
        
        return ;
    }
    
    function permute(array $nums)
    {
        $result = [];
        
        $this->solve($result, [], $nums, []);
        
        return $result;
    }
}

$arr = [1,2,3];
(new PermuteProblem())->permute($arr);
