<?php
/**
 * Created by PhpStorm.
 * User: sui
 * Date: 2019/4/10
 * Time: 17:51
 */

/**
 * 题目要求：
 * 给你一根长度为n的绳子，请把绳子剪成m段，记每段绳子长度为k[0],k[1]...k[m-1],求k[0]k[1]...k[m-1]的最大值。已知绳子长度n为整数，m>1(至少要剪一刀，不能不剪)，k[0],k[1]...k[m-1]均要求为整数。
 * 例如，绳子长度为8时，把它剪成3-3-2，得到最大乘积18；绳子长度为3时，把它剪成2-1，得到最大乘积2。
 * Class CutScopesProblem
 */
class CutScopesProblem
{
    
    /**
     * @param int $length 绳子长度
     *
     * @return int|mixed
     */
    public function cut($length)
    {
        if ($length < 2) {
            return 0;
        }
        
        if ($length == 2) {
            return 1;
        }
        if ($length == 3) {
            return 2;
        }
        $result = [
            0 => 0, //长度为1,最终只能是0
            1 => 1, //长度为2，最终只能是1
            2 => 1, //长度为3,最终只能是2
            3 => 3, //长度为4，最终只能是3
        ];
        
        $max = PHP_INT_MIN;
        for ($i = 4; $i <= $length; $i++) {
    
            $halfLength = floor($i/2);
            for ($j = 1; $j <= $halfLength; $j++) {
                $temp = $result[$j] * $result[$i - $j];
                $max  = max($max, $temp);
            }
            $result[$i] = $max;
        }
        
        return $result[$length];
    }
}

$solution = new CutScopesProblem();

$result = $solution->cut(10);

var_dump($result);