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
     * 第i行用过的数字
     * @var array
     */
    private $rowUsedNumbers = [];

    /**
     * 第j列用过的数字
     * @var array
     */
    private $columnUsedNumbers = [];

    /**
     * 第m*n个小方格用过的数字
     * @var
     */
    private $squareUsedNumbers;

    /**
     * 解数独。
     * 给出来一个填了一部分的数独棋盘，解出来答案
     *
     * @param string[][] $board
     * @param            $row
     * @param            $column
     * @return bool
     */
    function solve(&$board, $row = 0, $column = 0)
    {
        $this->printBoard($board, $row, $column, true);

        //找到下一个要去规划的点
        while ($board[$row][$column] != '.') {
            if (++$column >= 9) {
                $row++;
                $column = 0;
            }
            if ($row >= 9) {
                return true;
            }
        }

        $squareRow    = intval($row / 3);
        $squareColumn = intval($column / 3);
        for ($value = 1; $value <= 9; $value++) {
            if (in_array($value, $this->rowUsedNumbers[$row]) ||
                in_array($value, $this->columnUsedNumbers[$column]) ||
                in_array($value, $this->squareUsedNumbers[$squareRow][$squareColumn])
            ) {
                continue;
            }
            //往这个位置放置这个值
            $board[$row][$column]               = $value;
            $this->rowUsedNumbers[$row][]       = $value;
            $this->columnUsedNumbers[$column][] = $value;
            $this->squareUsedNumbers[$squareRow][$squareColumn][] = $value;

            if ($this->solve($board, $row, $column)) {
                return true;
            }

            //重置这个位置的元素
            $board[$row][$column] = '.';
            array_pop($this->rowUsedNumbers[$row]);
            array_pop($this->columnUsedNumbers[$column]);
            array_pop($this->squareUsedNumbers[$squareRow][$squareColumn]);
        }
        return false;
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

    /**
     * @param string[][] $board
     * @return bool
     */
    public function printBoard($board, $row, $column, $print = false)
    {
        system('clear');
        $result = true;
        for ($i = 0; $i < 9; $i++) {
            if ($print) {
                echo "[ ";
            }
            for ($j = 0; $j < 9; $j++) {
                if ($board[$i][$j] == '.') {
                    $result = false;
                }
                if ($print) {
                    if ($row == $i && $column == $j) {
                        echo "\e[1;32m{$board[$i][$j]}\033[0m    ";
                    } else {
                        echo "{$board[$i][$j]}    ";
                    }
                }
            }
            if ($print) {
                echo "] " . PHP_EOL;
            }
        }

//        sleep(1);
        if ($print) {
            echo PHP_EOL . PHP_EOL;
        }
        return $result;
    }

    /**
     * 计算这个位置当前的合法元素
     * @param array $board
     * @param int   $row
     * @param int   $column
     * @return array
     */
    private function getValidNumbers($board, int $row, int $column)
    {
        $result = range(1, 9);
        for ($n = 1; $n <= 9; $n++) {
            //探索行列是否合法
            for ($i = 0; $i < 9; $i++) {
                //判断当前行、列
                if ($board[$row][$i] == $n || $board[$i][$column] == $n) {
                    unset($result[$n - 1]);
                    //当前这个数字肯定不行了，直接跳过
                    continue 2;
                }
            }

            //计算在第几个小方格, 3/3=1(其实是第二个小方格)
            $rowNum    = floor($row / 3);
            $columnNum = floor($column / 3);

            for ($i = $rowNum * 3; $i < ($rowNum + 1) * 3; $i++) {
                for ($j = $columnNum * 3; $j < ($columnNum + 1) * 3; $j++) {
                    if ($board[$i][$j] == $n) {
                        unset($result[$n - 1]);
                        //当前这个数字肯定不行了，直接跳过
                        continue 3;
                    }
                }
            }
        }

        return array_values($result);
    }

    public function solveSudoku($board)
    {
        //初始化记录各个行列能用的数字
        $this->initMetadata($board);

        $this->solve($board, 0, 0);

        $this->printBoard($board, -1, -1, true);
    }

    /**
     * 初始化第i行,j列能用的元素
     * @param $board
     */
    private function initMetadata($board)
    {
        //探索行列是否合法
        for ($i = 0; $i < 9; $i++) {
            for ($j = 0; $j < 9; $j++) {
                if ($board[$i][$j] != '.') {
                    $squareRow                                            = intval($i / 3);
                    $squareColumn                                         = intval($j / 3);
                    $this->rowUsedNumbers[$i][]                           = $board[$i][$j];
                    $this->columnUsedNumbers[$j][]                        = $board[$i][$j];
                    $this->squareUsedNumbers[$squareRow][$squareColumn][] = $board[$i][$j];
                }
            }
        }
    }

}

$board = [
//    ['5', '3', '.', '.', '7', '.', '.', '.', '.'],
    ['5', '3', '4', '6', '7', '8', '9', '1', '.'],
    ['6', '.', '.', '1', '9', '5', '.', '.', '.'],
    ['.', '9', '8', '.', '.', '.', '.', '6', '.'],
    ['8', '.', '.', '.', '6', '.', '.', '.', '3'],
    ['4', '.', '.', '8', '.', '3', '.', '.', '1'],
    ['7', '.', '.', '.', '2', '.', '.', '.', '6'],
    ['.', '6', '.', '.', '.', '.', '2', '8', '.'],
    ['.', '.', '.', '4', '1', '9', '.', '.', '5'],
    ['.', '.', '.', '.', '8', '.', '.', '7', '9'],
];


$solution = (new SudokuProblem());

$solution->solveSudoku($board);

