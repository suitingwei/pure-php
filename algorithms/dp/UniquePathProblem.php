<?php
/**
 * Created by PhpStorm.
 * User: sui
 * Date: 2019/3/29
 * Time: 14:27
 */

class UniquePathProblem
{
    /**
     * @param Integer[][] $matrix
     *
     * @return Integer
     */
    function uniquePaths($m,$n)
    {
        return $this->solveByDP($m,$n);
    }
    
    /**
     * 使用动态规划来求解最小路径
     * 因为都每一个格子都只能往左或者往右，对于dp[i][j]来说，因为到达他
     * 只能是来自dp[i-1][j]和dp[i][j-1]，所以他的唯一路径就是这两个解之和
     *
     * @param int $width  矩阵宽度
     * @param int $length 矩阵深度
     *
     * @return int
     */
    private function solveByDP($width,$length)
    {
        //初始化结果集
        $dp = array_fill(0, $length, array_fill(0, $width, 0));
        
        print_r($dp);
        //初始化第一行的数据,因为只能横着走，所以第一行肯定只有一种路径
        for ($i = 0; $i < $width; $i++) {
            $dp[0][$i] = 1;
        }
        
        //初始化第一列数据,同理第一行
        for ($i = 0; $i < $length; $i++) {
            $dp[$i][0] = 1;
        }
        
        //构建状态转移
        for ($i = 1; $i < $length; $i++) {
            for ($j = 1; $j < $width; $j++) {
                //如果这个值还没有用过
                if ($dp[$i][$j] == 0) {
                    $dp[$i] [$j] = $dp[$i - 1][$j]+ $dp[$i][$j - 1];
                }
            }
        }
        return $dp[$length-1][$width-1];
    }
    
}

$solution = new  UniquePathProblem();
$m=3;
$n=2;
$uniquePaths = $solution->uniquePaths($m,$n);

var_dump($uniquePaths);
