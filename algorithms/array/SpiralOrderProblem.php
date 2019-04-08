<?php
/**
 * Created by PhpStorm.
 * User: sui
 * Date: 2019/4/8
 * Time: 15:53
 */

class SpiralOrderProblem
{
    /**
     * @param Integer[][] $matrix
     *
     * @return Integer[]
     */
    function spiralOrderOriginal($matrix)
    {
        $rowsCount = count($matrix);
        if ($rowsCount == 0) {
            return [];
        }
        $columnsCount = count($matrix[0]);
        
        /**
         * 还没有遍历完的节点，用来做外层循环的终止条件
         *
         * @var int
         */
        $leftNodes = $columnsCount * $rowsCount;
        
        /**
         * 行走方向。
         * 0=>从左往右; 1=>从上往下; 2=>从右往左; 3=>从下往上;
         *
         * @var int
         */
        $turn = 0;
        
        /**
         * 最终结果集
         *
         * @var Integer[]
         */
        $result = [];
        
        /**
         * 遍历过的列
         *
         * @var array
         */
        $usedColumns = [];
        
        /**
         * 遍历过的行
         *
         * @var array
         */
        $usedRows = [];
        
        echo "RowsCount:{$rowsCount},ColumnsCount:{$columnsCount},NodesCount:{$leftNodes}\n";
        while ($leftNodes > 0) {
            echo "LeftNodes:{$leftNodes}...\n";
            //横向遍历算法,从左往右
            if ($turn == 0) {
                for ($row = 0; $row < $rowsCount; $row++) {
                    //如果遍历过这一行,直接跳过
                    if (in_array($row, $usedRows)) {
                        continue;
                    }
                    for ($column = 0; $column < $columnsCount; $column++) {
                        //如果遍历过这一列，跳过
                        if (in_array($column, $usedColumns)) {
                            continue;
                        }
                        $result[] = $matrix[$row][$column];
                        $leftNodes--;
                    }
                    $usedRows [] = $row;
                    $turn        = ($turn + 1) % 4;
                    break;
                }
            } //从右往左遍历，但是需要从最下边的行往上走
            elseif ($turn == 2) {
                for ($row = $rowsCount - 1; $row >= 0; $row--) {
                    //如果遍历过这一行,直接跳过
                    if (in_array($row, $usedRows)) {
                        continue;
                    }
                    for ($column = $columnsCount - 1; $column >= 0; $column--) {
                        //如果遍历过这一列，跳过
                        if (in_array($column, $usedColumns)) {
                            continue;
                        }
                        $result[] = $matrix[$row][$column];
                        $leftNodes--;
                    }
                    $usedRows [] = $row;
                    $turn        = ($turn + 1) % 4;
                    break;
                }
            } //从上往下遍历，但是注意整个列要从右往左来
            elseif ($turn == 1) {
                for ($column = $columnsCount - 1; $column >= 0; $column--) {
                    //如果遍历过这一列,直接跳过
                    if (in_array($column, $usedColumns)) {
                        continue;
                    }
                    //从下往上
                    if ($turn == 1) {
                        for ($row = 0; $row < $rowsCount; $row++) {
                            //如果遍历过这一列，跳过
                            if (in_array($row, $usedRows)) {
                                continue;
                            }
                            $result[] = $matrix[$row][$column];
                            $leftNodes--;
                        }
                    }
                    $usedColumns[] = $column;
                    $turn          = ($turn + 1) % 4;
                    break;
                }
            } elseif ($turn == 3) {
                for ($column = 0; $column < $columnsCount; $column++) {
                    //如果遍历过这一列,直接跳过
                    if (in_array($column, $usedColumns)) {
                        continue;
                    }
                    for ($row = $rowsCount - 1; $row >= 0; $row--) {
                        //如果遍历过这一行，跳过
                        if (in_array($row, $usedRows)) {
                            continue;
                        }
                        $result[] = $matrix[$row][$column];
                        $leftNodes--;
                    }
                    $usedColumns[] = $column;
                    $turn          = ($turn + 1) % 4;
                    break;
                }
            }
        }
        
        return $result;
    }
    
    function spiralOrder($matrix)
    {
        $rowsCount = count($matrix);
        if ($rowsCount == 0) {
            return [];
        }
        $columnsCount = count($matrix[0]);
        
        $up    = 0;
        $down  = $rowsCount - 1;
        $left  = 0;
        $right = $columnsCount - 1;
        
        $result = [];
        while (true) {
            for ($i = $left; $i <= $right; $i++)  $result [] = $matrix[$up] [$i];
            if (++$up > $down)  break;
            
            //从上往下，最右边这一列
            for ($i = $up; $i <= $down; $i++)  $result [] = $matrix[$i] [$right];
            if (--$right < $left)  break;
    
            //从右往左
            for ($i = $right; $i >= $left; $i--)  $result [] = $matrix[$down] [$i];
            if (--$down < $up)  break;
            
            //从下往上
            for ($i = $down; $i >= $up; $i--)  $result [] = $matrix[$i] [$left];
            if (++$left > $right)  break;
        }
        
        return $result;
    }
}

$matrix   = [
    [1, 2, 3, 4],
    [5, 6, 7, 8],
    [9, 10, 11, 12]
];
$solution = new SpiralOrderProblem();
$result   = $solution->spiralOrder($matrix);
print_r($result);