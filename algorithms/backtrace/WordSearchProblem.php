<?php
/**
 * Created by PhpStorm.
 * User: sui
 * Date: 2019-03-24
 * Time: 12:52
 */

/**
 * Class WordSearchProblem
 * @link https://leetcode-cn.com/problems/word-search/
 */
class WordSearchProblem
{
    private $boardColumns;

    private $boardRows;

    /**
     * 搜索一个二维字母矩阵是否存在连续路径能拼接出来单词
     * @param String[][] $board
     * @param String     $word
     * @return Boolean
     */
    function exist($board, $word)
    {
        $result             = [];
        $this->boardRows    = count($board);
        $this->boardColumns = count($board[0]);
        $existResult =$this->try($board, $word, 0, 0, 0, $result, []);

        return $existResult;
    }

    /**
     * @param string[][] $board
     * @param string     $word
     * @param int        $row
     * @param int        $column 当前扫描的矩阵的列
     * @param int        $matchIndex 当前匹配的串的下标索引
     * @param int[][] &  $result 最终结果集
     * @param int[][]    $tempResult 临时存储的结果，为了方便索引某一个点是否用过，所以这个结果使用如下格式:
     *                            [ ["row1-column1" => [row1,column1] ,["row2-column2" => [row2,column2] ]
     * @return bool
     */
    function try($board, $word, $row, $column, $matchIndex, &$result, $tempResult)
    {
        $this->printArray($board, $word, $row, $column, $matchIndex, $result, $tempResult);
        if ($matchIndex == strlen($word)) {
            $result[] = $tempResult;
            return true;
        }
        $matchChar = $word[$matchIndex];

        //如果还没有开始进行尝试，那么从整个矩阵中找到第一个符合条件的位置
        if (empty($tempResult)) {
            $points = $this->findFirstMatchPoint($board, $matchChar);
        } //如果已经匹配过了，那么这一次要在上一次匹配的周围去匹配
        else {
            $points = $this->getValidPoints($row, $column, $tempResult);
        }

        if (empty($points)) {
            return false;
        }
        foreach ($points as list($nextRow, $nextColumn)) {
            if($board[$nextRow][$nextColumn] != $matchChar){
                continue;
            }
            $key              = "{$nextRow}-{$nextColumn}";
            $tempResult[$key] = [$nextRow, $nextColumn];
            if($this->try($board, $word, $nextRow, $nextColumn, $matchIndex + 1, $result, $tempResult)){
                return true;
            }
            array_pop($tempResult);
        }
        return false;
    }

    /**
     * 找到某一个点的邻接点
     * @param int     $row
     * @param int     $column
     * @param int[][] $usedPoints
     * @return array
     */
    public function getValidPoints($row, $column, $usedPoints = [])
    {
        $result = [
            0 => [$row - 1, $column], //top
            1 => [$row + 1, $column], //down
            2 => [$row, $column - 1], //left
            3 => [$row, $column + 1] //right
        ];

        //如果是最上面一行，那么没有 top
        if ($row == 0) {
            unset($result[0]);
        }
        //最下面一行没有 down
        if ($row == ($this->boardRows - 1)) {
            unset($result[1]);
        }

        //最左边一列没有 left
        if ($column == 0) {
            unset($result[2]);
        }

        //最右边一列没有 right
        if ($column == ($this->boardColumns - 1)) {
            unset($result[3]);
        }

        return array_values(array_filter($result, function ($point) use ($usedPoints) {
            $key = "{$point[0]}-{$point[1]}";
            return !isset($usedPoints[$key]);
        }));
    }


    public function printArray($board, $word, $row, $column, $matchIndex, $result, $tempResult)
    {
        system('clear');
        echo sprintf("TempResult:%s\n", json_encode(array_values($tempResult)));
        echo sprintf("Target Word:\e[;93m%s\e[0m,Current Matching Character:\e[1;32m%s\e[0m\n",$word,$word[$matchIndex]??'');
        for ($i = 0; $i < $this->boardRows; $i++) {
            echo "[   ";
            for ($j = 0; $j < $this->boardColumns; $j++) {
                $key  = "{$i}-{$j}";
                if(isset($tempResult[$key])){
                    echo "\e[1;32m{$board[$i][$j]}\033[0m    ";
                }
                else{
                    echo "{$board[$i][$j]}    ";
                }
            }
            echo "]" . PHP_EOL;
        }
        sleep(1);
    }

    /**
     * 在矩阵中找到第一个符合匹配字符的位置
     * @param $board
     * @param $matchChar
     * @param $tempResult
     * @return array
     */
    public function findFirstMatchPoint($board, $matchChar): array
    {
        $result = [];
        for($i=0;$i<$this->boardRows;$i++){
            for($j=0;$j<$this->boardColumns;$j++){
               if($board[$i][$j] == $matchChar){
                   $result[] = [$i,$j];
               }
            }
        }

        return $result;
    }

}

$board    =
    [
        ['A', 'B', 'C', 'E','B','E','G','H','I','Z'],
        ['S', 'F', 'C', 'S','D','V','A','C','E','Y'],
        ['A', 'D', 'E', 'E','E','G','Q','E','W','E'],
        ['E', 'F', 'F', 'N','D','X','L','O','E','E'],
        ['W', 'A', 'K', 'W','T','G','P','V','G','H'],
        ['E', 'C', 'L', 'E','Z','Z','E','V','Q','H'],
    ];
//$board =[["C","A","A"],["A","A","A"],["B","C","D"]];
$word     = "AKWTDEGXGPVGEWEY";
$solution = new WordSearchProblem();
$result   = $solution->exist($board, $word);

var_dump($result);


