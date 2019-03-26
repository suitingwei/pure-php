<?php

/**
 * N皇后
 *
 * @link https://leetcode-cn.com/problems/n-queens/
 */
class NQueensProblem
{
    /**
     * @param Integer $n
     *
     * @return String[][]
     */
    function solveNQueens($n)
    {
        $result = [];
        
        //因为 leetcode 需要使用字符串形式，所以改不用 array了
        $board = array_fill(0, $n, str_repeat('.', $n ));
        
        $this->try(0, $n, $result, $board);
        
        return $result;
    }
    
    /**
     * @param int     $row    当前探索的行号
     * @param         $n
     * @param array[] $result 结果集
     * @param         $tempResult
     *
     * @return bool
     */
    function try($row, $n, &$result, $tempResult)
    {
        $this->printArray($row, $n, $tempResult);
        //如果已经放到了最后一行，那么就完事了
        if ($row == $n) {
            $result [] = $tempResult;
            
            return true;
        }
        for ($column = 0; $column < $n; $column++) {
            //判断这一行的那一列是合法的坐标点
            if ($this->isValidPoint($row, $column, $n, $tempResult)) {
                //放置皇后在这个点
                $tempResult[$row][$column] = 'Q';
                
                $this->try($row + 1, $n, $result, $tempResult);
                
                //回溯这个位置
                $tempResult[$row][$column] = '.';
            }
        }
        
        return false;
    }
    
    /**
     * @param int        $row        当前要放皇后的行
     * @param int        $column     当前要放皇后的列
     * @param string[][] $tempResult 当前棋盘
     *
     * @return bool
     */
    private function isValidPoint($row, $column, $n, $tempResult)
    {
        $leftCorner  = $column - 1;
        $rightCorner = $column + 1;
        
        //因为是一行一行的下棋的，所以
        for ($i = $row - 1; $i >= 0; $i--) {
            //当前列的上一行是否有值
            if ($tempResult[$i][$column] == 'Q') {
                return false;
            }
            
            //考察左上对角线,第i行第leftUp列
            if ($leftCorner >= 0) {
                if ($tempResult[$i][$leftCorner] == 'Q') {
                    return false;
                }
            }
            
            //考察右上角对角线，第i行rightUp列是否有值
            if ($rightCorner < $n) {
                if ($tempResult[$i][$rightCorner] == 'Q') {
                    return false;
                }
            }
            $leftCorner--;
            $rightCorner++;
        }
        
        return true;
    }
    
    public function printArray($row, $n, $tempResult)
    {
        system('clear');
        echo sprintf("Current Row:\e[;93m%s\e[0m\n", $row);
        echo sprintf("Total Rows:\e[;93m%s\e[0m\n", $n);
        for ($i = 0; $i < $n; $i++) {
            echo "[   ";
            for ($j = 0; $j < $n; $j++) {
                echo "{$tempResult[$i][$j]}    ";
            }
            echo "]" . PHP_EOL;
        }
        sleep(1);
    }
}

$solution = (new NQueensProblem());
$n        = 10;
$result   = $solution->solveNQueens($n);

foreach ($result as $eachSolution) {
    $solution->printArray($n, $n, $eachSolution);
}
