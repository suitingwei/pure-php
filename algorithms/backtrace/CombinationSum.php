<?php
/**
 * Created by PhpStorm.
 * User: sui
 * Date: 2019/3/5
 * Time: 14:59
 */

class CombinationSum
{
    private $result = [];
    private $finalResult =[];
    
    /**
     * 给定一个数组的数字，求出所有可能组成target的组合
     * ----------------------------------------------------------------------------------------
     * 给定一个无重复元素的数组 candidates 和一个目标数 target ，找出 candidates 中所有可以使数字和为 target 的组合。
     * candidates 中的数字可以无限制重复被选取。
     *
     * @link https://leetcode-cn.com/problems/combination-sum/
     *
     * @param array $candidates
     * @param int   $target
     *
     * @return bool
     */
    function solution(array $candidates, int $target)
    {
        //因为最终我们要拼出来的是一个目标值,target,可以每次都在候选数组中选择一个数字,只要他们之和还小于target,那么就可以继续搜索
        if (($previousSum = array_sum($this->result)) == $target) {
            $this->finalResult[] = $this->result;
            
            return true;
        }
        
        if($previousSum > $target){
            return false;
        }
        
        //对于每一个
        foreach ($candidates as $index => $candidate) {
            //如果当前这个数字+ 之前的和超过了目标值，那么肯定没戏了
            if ($previousSum + $candidate > $target) {
                //echo "PreviousSum:{$previousSum},\tCandidate:{$candidate},\tTarget:{$target}\n";
                continue;
            }
            //把当前的值放入
            $this->result [] = $candidate;
           
            //递归一把，算一下以这个值作为基点能不能产生可行解
            $this->solution(array_slice($candidates,$index),$target);
            
            array_pop($this->result);

        }
        return false;
    }
    
    function combinationSumSolution(array $candidates,int $target){
        $this->solution($candidates,$target);
        
        return $this->finalResult;
    }
    
    /**
     *
     */
    private function printResult()
    {
        foreach ($this->result as $item) {
            echo "$item\t";
        }
        echo "\n";
    }
    
}

$candidates = [2,3,6,7];
$target = 7;
print_r( (new CombinationSum())->combinationSumSolution($candidates,$target));