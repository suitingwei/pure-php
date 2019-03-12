<?php
/**
 * Created by PhpStorm.
 * User: sui
 * Date: 2019/3/11
 * Time: 18:26
 */

class ProductExceptSelfProblem
{
    
    
    /**
     * @param Integer[] $nums
     *
     * @return Integer[]
     */
    function productExceptSelf($nums)
    {
        $s   = 1;
        $rs  = 1;
        $n   = count($nums);
        $pre = $after = $output = [];
        
        for ($i = 1; $i < $n; $i++) {
            $rs                 = $rs * $nums[$n - $i];
            $after[$n - $i - 1] = $rs;
            
            $s       = $s * $nums[$i - 1];
            $pre[$i] = $s;
        }
        $after[$n - 1] = 1;
        $pre[0]        = 1;
        
        for ($i = 0; $i <= $n - 1; $i++) {
            $output[$i] = $pre[$i] * $after[$i];
        }
        
        return $output;
    }
}

(new ProductExceptSelfProblem())->productExceptSelf([1, 2, 3, 4]);