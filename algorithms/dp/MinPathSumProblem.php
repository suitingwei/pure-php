<?php
/**
 * Created by PhpStorm.
 * User: sui
 * Date: 2019/3/29
 * Time: 14:27
 */

class MinPathSumProblem
{
    /**
     * @param Integer[][] $matrix
     *
     * @return Integer
     */
    function minPathSum($matrix)
    {
//        $result = PHP_INT_MAX;
//        $this->solveByRecursive($matrix, 0, 0, 0, $result);
//
//        return $result;
        return $this->solveByDP($matrix);
    }
    
    /**
     * 使用动态规划来求解最小路径
     * 因为都每一个格子都只能往左或者往右，对于dp[i][j]来说，他的最小值是 min (dp[i-1][j], dp[i][j-1]),也就是说
     * 到达这一步的最小值，要么是来自上边的，要么是来自左边的。
     *
     * @param Integer[][] $matrix
     *
     * @return int
     */
    private function solveByDP($matrix)
    {
        if (empty($matrix)) {
            return 0;
        }
        $rowsCount    = count($matrix);
        $columnsCount = count($matrix[0]);
        
        //初始化结果集
        $dp = array_fill(0, $rowsCount, array_fill(0, $columnsCount, 0));
        
        //初始化第一行的数据
        $sum      = $matrix[0][0];
        $dp[0][0] = $matrix[0][0];
        for ($i = 1; $i < $columnsCount; $i++) {
            $sum       += $matrix[0][$i];
            $dp[0][$i] = $sum;
        }
        
        //初始化第一列数据
        $sum = $matrix[0][0];
        for ($i = 1; $i < $rowsCount; $i++) {
            $sum       += $matrix[$i] [0];
            $dp[$i][0] = $sum;
        }
        
        //构建状态转移
        for ($i = 1; $i < $rowsCount; $i++) {
            for ($j = 1; $j < $columnsCount; $j++) {
                //如果这个值还没有用过
                if ($dp[$i][$j] == 0) {
                    $dp[$i] [$j] = min($dp[$i - 1][$j], $dp[$i][$j - 1]) + $matrix[$i][$j];
                }
            }
        }
        return $dp[$rowsCount-1][$columnsCount-1];
    }
    
    /**
     * @param $matrix
     * @param $row
     * @param $column
     * @param $int2
     */
    private function solveByRecursive($matrix, $row, $column, $tempResult, &$result)
    {
        $rowsCount    = count($matrix);
        $columnsCount = count($matrix[0]);
        
        if ($row == ($rowsCount - 1) && ($column == $columnsCount - 1)) {
            $tempResult += $matrix[$row][$column];
            
            if ($tempResult < $result) {
                $result = $tempResult;
            }
            
            return;
        }
        
        if ($row < $rowsCount - 1) {
            $this->solveByRecursive($matrix, $row + 1, $column, $tempResult + $matrix[$row][$column], $result);
        }
        
        if ($column < $columnsCount - 1) {
            $this->solveByRecursive($matrix, $row, $column + 1, $tempResult + $matrix[$row][$column], $result);
        }
        
        return;
    }
}

$solution = new MinPathSumProblem();
$matrix   = [
    [1, 3, 1],
    [1, 5, 1],
    [4, 2, 1]
];
$minPath  = $solution->minPathSum($matrix);

var_dump($minPath);
