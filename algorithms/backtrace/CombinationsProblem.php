<?php
/**
 * Created by PhpStorm.
 * User: sui
 * Date: 2019/3/22
 * Time: 14:09
 */

class CombinationsProblem
{
    /**
     * @param Integer $n
     * @param Integer $k
     *
     * @return Integer[][]
     */
    function combine($n, $k)
    {
        $result = [];
        
        $this->try($n, $k, 1, $result, []);
        
        return $result;
    }
    
    /**
     * @param $n
     * @param $k
     * @param $startNum
     * @param $result
     * @param $tempResult
     */
    function try($n, $k, $startNum, &$result, $tempResult)
    {
        if (count($tempResult) == $k) {
            $result [] = $tempResult;
            
            return;
        }
        
        for ($i = $startNum; $i <= $n; $i++) {
            $tempResult [] = $i;
            $this->try($n, $k, $i + 1, $result, $tempResult);
            array_pop($tempResult);
        }
        
        return;
    }
}

$result = (new CombinationsProblem())->combine(4,2);
print_r($result);