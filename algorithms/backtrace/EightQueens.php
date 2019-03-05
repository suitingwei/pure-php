<?php

/**
 * Created by PhpStorm.
 * User: sui
 * Date: 2019/3/5
 * Time: 14:23
 */
class EightQueens
{
    /**
     * 保存每一次的八皇后的解,用完之后会清空
     * @var array
     */
    private $result = [];
    
    /**
     * 把八皇后求解的问题拆分为8步。每一步都去找某一行的可以放置的位置,从棋盘最上面开始摆放。
     * 比如从第0行开始查找，第一个棋子肯定是可以随意摆放，随后第二个棋子在第二行的时候就需要在这
     * 八列中查找可用的位置，然后摆放到这个位置。随后摆放下一行。
     * @param int $row
     */
    function calculateEightQueens(int $row)
    {
        //已经找到了第八行，打印结果
        if ($row == 8) {
            $this->printResult();
            return;
        }
        
        //每一行都有八种摆放的方法
        for ($column = 0; $column < 8; ++$column) {
            //判断当前这一列能够摆放
            if ($this->isOk($row, $column)) {
                $this->result[$row] = $column;
                //考察下一行
                $this->calculateEightQueens($row + 1);
            }
        }
    }
    
    function printResult()
    {
        for ($i = 0; $i < 8; $i++) {
            for ($j = 0; $j < 8; $j++) {
                if ($this->result[$i] == $j) {
                    echo "Q\t";
                } else {
                    echo "*\t";
                }
            }
            echo PHP_EOL;
        }
        echo "------------------------" . PHP_EOL;
    }
    
    /**
     * @param $row
     * @param $column
     *
     * @return bool
     */
    function isOk($row, $column)
    {
        $leftUp  = $column - 1;
        $rightUp = $column + 1;
        
        for ($i = $row - 1; $i >= 0; $i--) {
            //考察第i行的地column列是否有值
            if ($this->result[$i] == $column) {
                return false;
            }
            
            //考察左上对角线,第i行第leftUp列
            if ($leftUp >= 0) {
                if ($this->result[$i] == $leftUp) {
                    return false;
                }
            }
            
            //考察右上角对角线，第i行rightUp列是否有值
            if ($rightUp < 8) {
                if ($this->result[$i] == $rightUp) {
                    return false;
                }
            }
            
            $leftUp--;
            $rightUp++;
        }
        
        return true;
    }
}

(new EightQueens())->calculateEightQueens(0);