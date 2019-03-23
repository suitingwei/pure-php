<?php
/**
 * Created by PhpStorm.
 * User: sui
 * Date: 2019/3/22
 * Time: 17:05
 */

class SudokuProblem
{
    /**
     * 解数独。
     * 给出来一个填了一部分的数独棋盘，解出来答案
     *
     * @param string[][] $board
     * @param            $row
     * @param            $column
     */
    function slove($board, $usedRows, $usedColumns)
    {
        if (count($usedRows) == 9 and count($usedColumns) == 9) {
            echo "Success!\n";
            
            return;
        }
        for ($row = 0; $row < 9; $row++) {
            for ($column=0; $column < 9; $column++) {
                //如果这个数独的当前位置不是空直接跳过
                if ($board[$row][$column] != '.') {
                    $usedRows[]= $row;
                    $usedColumns[] =$column;
                    continue 2;
                }
                //尝试1-9的元素
                for ($value = 1; $value <= 9; $value++) {
                    if ($this->isValid($board, $row, $column, $value)) {
                        //往这个位置放置这个值
                        $board[$row][$column] = $value;
                        
                        $this->slove($board, $row + 1, $column + 1);
                        
                        //重置这个位置的元素
                        $board[$row][$column] = '.';
                    }
                }
            }
        }
    }
    
    /**
     * 当前这个位置是否能够放置当前元素
     *
     * @param string[][] $board
     * @param int        $row
     * @param int        $column
     * @param int        $value
     *
     * @return bool
     */
    public function isValid(&$board, int $row, int $column, int $value)
    {
        //探索行列是否合法
        for ($i = 0; $i < 9; $i++) {
            //判断当前行
            if ($board[$row][$i] == $value) {
                return false;
            }
            //判断当前列
            if ($board[$i][$column] == $value) {
                return false;
            }
        }
        
        //计算在第几个小方格, 3/3=1(其实是第二个小方格)
        $rowNum    = floor($row / 3);
        $columnNum = floor($column / 3);
        
        for ($i = $rowNum * 3; $i < ($rowNum + 1) * 3; $i++) {
            for ($j = $columnNum * 3; $j < ($columnNum + 1) * 3; $j++) {
                if ($board[$i][$j] == $value) {
                    return false;
                }
            }
        }
        return true;
    }
}

$board = [
    ['5', '3', '.', '.', '7', '.', '.', '.', '.'],
    ['6', '.', '.', '1', '9', '5', '.', '.', '.'],
    ['.', '9', '8', '.', '.', '.', '.', '6', '.'],
    ['8', '.', '.', '.', '6', '.', '.', '.', '3'],
    ['4', '.', '.', '8', '.', '3', '.', '.', '1'],
    ['7', '.', '.', '.', '2', '.', '.', '.', '6'],
    ['.', '6', '.', '.', '.', '.', '2', '8', '.'],
    ['.', '.', '.', '4', '1', '9', '.', '.', '5'],
    ['.', '.', '.', '.', '8', '.', '.', '7', '9']
];

$result = (new SudokuProblem())->isValid($board,3,5,9);

var_dump($result);