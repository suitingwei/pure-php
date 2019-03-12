<?php

/**
 * Class PermuteProblem2
 *
 * @link https://leetcode-cn.com/problems/permutations-ii/
 */
class PermuteProblem2
{
    function solve(array &$result, array $tempResult, array $nums, array $usedIndex = [])
    {
        $length = count($nums);
        
        if (count($tempResult) == $length) {
            echo "Generated Success:" . json_encode($tempResult) . PHP_EOL;
            $uniqueKey =  implode($tempResult);
            $result[$uniqueKey] = $tempResult;
            
            return;
        }
        
        for ($i = 0; $i < $length; $i++) {
            if(in_array($i,$usedIndex)){
                continue;
            }
         
            $tempResult [] = $nums[$i];
            $usedIndex[]   = $i;
            $this->solve($result, $tempResult, $nums, $usedIndex);
            array_pop($tempResult);
            array_pop($usedIndex);
        }
        
        return;
    }
    
    function permute(array $nums)
    {
        $result = [];
        
        sort($nums);
        
        $this->solve($result, [], $nums,[]);
        
        return $result;
    }
    
}

$arr = [1, 2, 1];
print_r((new PermuteProblem2())->permute($arr));
