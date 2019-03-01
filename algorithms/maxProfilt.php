<?php
/**
 * Created by PhpStorm.
 * User: sui
 * Date: 2019/2/27
 * Time: 17:23
 */
$arr = [
    ["8", "3", ".", ".", "7", ".", ".", ".", "."],
    ["6", ".", ".", "1", "9", "5", ".", ".", "."],
    [".", "9", "8", ".", ".", ".", ".", "6", "."],
    ["8", ".", ".", ".", "6", ".", ".", ".", "3"],
    ["4", ".", ".", "8", ".", "3", ".", ".", "1"],
    ["7", ".", ".", ".", "2", ".", ".", ".", "6"],
    [".", "6", ".", ".", ".", ".", "2", "8", "."],
    [".", ".", ".", "4", "1", "9", ".", ".", "5"],
    [".", ".", ".", ".", "8", ".", ".", "7", "9"]
];


function isValidSudoku($board)
{
    //按照行遍历看是否合法
    for ($row = 0; $row < count($board); $row++) {
        //把数组的值放到这个 set 里，用值作为 key，相当于set了
        //[ 0=>true, 1=>true],如果有重复元素，那么最终 set 长度肯定不是9
        $set   = [];
        $count = 0;
        for ($column = 0; $column < count($board[$row]); $column++) {
            $value = $board[$row][$column];
//            echo sprintf("[$row][$column]=$value\n");
            if ($value == '.') {
                $count++;
            } else {
                if (!isset($set[$value])) {
                    $set[$value] = true;
                    $count++;
                }
            }
            
        }
        
        if ($count != 9) {
            return false;
        }
    }
    
    //按照列遍历看是否合法
    for ($column = 0; $column < count($board); $column++) {
        //把数组的值放到这个 set 里，用值作为 key，相当于set了
        //[ 0=>true, 1=>true],如果有重复元素，那么最终 set 长度肯定不是9
        $set   = [];
        $count = 0;
        for ($row = 0; $row < count($board[$column]); $row++) {
            $value = $board[$row][$column];
//            echo sprintf("[$row][$column]=$value\n");
            if ($value == '.') {
                $count++;
            } else {
                if (!isset($set[$value])) {
                    $set[$value] = true;
                    $count++;
                }
            }
            
        }
        
        if ($count != 9) {
            return false;
        }
    }
    
    //按照九宫格遍历
    for ($row = 0; $row < count($board); $row += 3) {
        //把数组的值放到这个 set 里，用值作为 key，相当于set了
        //[ 0=>true, 1=>true],如果有重复元素，那么最终 set 长度肯定不是9
        for ($column = 0; $column < count($board[$row]); $column += 3) {
            $set   = [];
            $count = 0;
            for($i=$row;$i<3+$row;$i++){
                for($j=$column;$j<3+$column;$j++){
                    $value = $board[$i][$j];
//                    echo sprintf("九宫格遍历:[$i][$j]=$value\n");
                    if ($value == '.') {
                        $count++;
                    } else {
                        if (!isset($set[$value])) {
                            $set[$value] = true;
                            $count++;
                        }
                    }
                }
            }

            if ($count != 9) {
                return false;
            }
        }
        
    }
    
    return true;
}

var_dump(isValidSudoku($arr));
