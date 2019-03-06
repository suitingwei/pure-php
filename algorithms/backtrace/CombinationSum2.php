<?php
/**
 * Created by PhpStorm.
 * User: sui
 * Date: 2019/3/5
 * Time: 14:59
 */

class CombinationSum2
{
    /**
     * @var array
     */
    private $result = [];
    
    
    /**
     * 最终结果
     *
     * @var array
     */
    private $finalResult = [];
    
    /**
     * @param array $candidates
     * @param int   $target
     *
     * @return array|bool
     */
    function solve(array $candidates, int $target)
    {
        if (($previousSum = array_sum($this->result)) == $target) {
            $temp = $this->result;
            sort($temp);
            $hashKey = sha1(json_encode($temp));
            if(!isset($this->finalResult[$hashKey])){
                $this->finalResult [$hashKey] = $this->result;
            }
            return true;
        }
    
        foreach ($candidates as $index => $candidate) {
            if( ($candidate + $previousSum > $target)){
                continue;
            }
            if( isset($this->result[$index])) {
                continue;
            }
            
            $this->result [$index] = $candidate;
            
            $this->solve($candidates,$target);
            
            unset($this->result[$index]);
        }
        return $this->finalResult;
    }
    
}


$candidates = [1,2,7,5,10,6,1]; $target = 8;
//$candidates = [2,5,2,1,2];$target = 5;
//$candidates = [1];$target = 2;
print_r( (new CombinationSum2())->solve($candidates,$target));
