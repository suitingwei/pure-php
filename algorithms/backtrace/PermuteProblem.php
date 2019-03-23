<?php
/**
 * Created by PhpStorm.
 * User: sui
 * Date: 2019/3/6
 * Time: 10:07
 */

class PermuteProblem
{
    function solve(array &$result, array $tempResult, array $nums, $usedIndex= [],$depth=0)
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
            echo str_repeat("\t",$depth)."尝试使用{$nums[$i]}\n";
            $this->solve($result, $tempResult, $nums, $usedIndex,$depth+1);
            array_pop($usedIndex);
            echo str_repeat("\t",$depth)."回溯{$nums[$i]}\n";
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
