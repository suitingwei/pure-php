<?php
/**
 * Created by PhpStorm.
 * User: sui
 * Date: 2019/3/21
 * Time: 15:32
 */

class LetterCombinationProblem
{
    private static $mappings = [
        2 => ['a', 'b', 'c'],
        3 => ['d', 'e', 'f'],
        4 => ['g', 'h', 'i'],
        5 => ['j', 'k', 'l'],
        6 => ['m', 'n', 'o'],
        7 => ['p', 'q', 'r', 's'],
        8 => ['t', 'u', 'v'],
        9 => ['w', 'x', 'y', 'z'],
    ];
    
    /**
     * @param String $digits
     *
     * @return String[]
     */
    function letterCombinations($digits)
    {
        if (empty($digits)) {
            return [];
        }
        
        $result = [];
        
        $this->combine($digits, $result, "");
        
        return $result;
    }
    
    function combine($digits, &$result, $tempResult, $startIndex = 0)
    {
        if (strlen($digits) == strlen($tempResult)) {
            $result [] = $tempResult;
            
            return;
        }
        
        for ($i = $startIndex; $i < strlen($digits); $i++) {
            
            $mapping = static::$mappings[intval($digits[$i])];
            
            for ($j = 0; $j < count($mapping); $j++) {
                $tempResult .= $mapping[$j];
                
                $this->combine($digits, $result, $tempResult, $i + 1);
                
                $tempResult = substr($tempResult, 0, -1);
            }
        }
        
        return;
    }
}