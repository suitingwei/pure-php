<?php
/**
 * Created by PhpStorm.
 * User: sui
 * Date: 2019/3/21
 * Time: 16:17
 */

class GenerateParenthesisProblem
{
    private static $mappings = ['(', ')'];
    
    /**
     * @param Integer $n
     *
     * @return String[]
     */
    function generateParenthesis($n)
    {
        if ($n == 0) {
            return [];
        }
        
        $result = [];
        
        $this->generate($n, 0, 0, $result, "");
        
        return $result;
    }
    
    
    function generate($n, $leftCount, $rightCount, &$result, $tempResult)
    {
        if ($n*2 == ($leftCount + $rightCount)) {
            $result [] = $tempResult;
            
            return;
        }
        
        
        for ($i = 0; $i <= 1; $i++) {
            //选择右括号的时候，必须满足左括号的出现次数比右括号多
            if ($i == 1 && ($rightCount >= $leftCount)) {
                continue;
            }
            //选择左括号的时候，只能选出来 n 这个么
            if($i == 0 && $leftCount == $n){
                continue;
            }
            
            $tempResult .= static::$mappings[$i];
            
            echo "LeftCount:{$leftCount},\tRightCount:($rightCount},\tTempResult:{$tempResult}\n";
            if ($i == 0) {
                $this->generate($n, $leftCount + 1, $rightCount, $result, $tempResult);
            } else {
                $this->generate($n, $leftCount, $rightCount + 1, $result, $tempResult);
            }
            
            $tempResult = substr($tempResult, 0, -1);
        }
        
        return;
    }
}


print_r((new GenerateParenthesisProblem())->generateParenthesis(3));