<?php
/**
 * Created by PhpStorm.
 * User: sui
 * Date: 2019/3/29
 * Time: 14:27
 */

class UniquePathProblemII
{
    /**
     * @param Integer[][] $matrix
     *
     * @return Integer
     */
    function uniquePathsWithObstacles($obstacleGrid)
    {
        return $this->solveByDP($obstacleGrid);
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
    private function solveByDP($obstacleGrid)
    {
        $length = count($obstacleGrid);
        $width  = count($obstacleGrid[0]);
        
        //初始化结果集
        $dp = array_fill(0, $length, array_fill(0, $width, 0));
        
        $dp[0][0] = $this->isObstacle($obstacleGrid[0][0]) ? 0 : 1;
        
        //初始化第一行的数据,因为只能横着走，所以第一行肯定只有一种路径
        //但是因为目前是带有障碍物的，如果第一行某一个位置是障碍物，那么他只能是0了,并且如果某一个位置是障碍物之后，他后面的行都无法触发
        for ($i = 1; $i < $width; $i++) {
            if ($this->isObstacle($obstacleGrid[0][$i])) {
                $dp[0][$i] = 0;
            } else {
                $dp[0][$i] = $dp[0][$i - 1];
            }
        }
        
        //初始化第一列数据,同理第一行
        for ($i = 1; $i < $length; $i++) {
            if ($this->isObstacle($obstacleGrid[$i][0])) {
                $dp[$i][0] = 0;
            } else {
                $dp[$i][0] = $dp[$i - 1][0];
            }
        }
        
        
        //构建状态转移
        for ($i = 1; $i < $length; $i++) {
            for ($j = 1; $j < $width; $j++) {
                //如果这个值还没有用过
                if ($dp[$i][$j] == 0) {
                    //如果这个位置是障碍物，那么它的值直接是0
                    if ($this->isObstacle($obstacleGrid[$i][$j])) {
                        $dp[$i][$j] = 0;
                    } else {
                        $dp[$i] [$j] = $dp[$i - 1][$j] + $dp[$i][$j - 1];
                    }
                }
            }
        }
        
        return $dp[$length - 1][$width - 1];
    }
    
    /**
     * @param $obstacleGrid
     * @param $i
     *
     * @return bool
     */
    private function isObstacle($obstacleCell): bool
    {
        return $obstacleCell == 1;
    }
    
}

$solution     = new  UniquePathProblemII();
$obstacleGrid = [[0, 0, 0, 0], [0, 1, 0, 0], [0, 0, 1, 0], [0, 0, 0, 0]];
//$obstacleGrid=[[1,0]];
$uniquePaths = $solution->uniquePathsWithObstacles($obstacleGrid);

var_dump($uniquePaths);
