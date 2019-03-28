<?php
/**
 * Created by PhpStorm.
 * User: sui
 * Date: 2019-03-27
 * Time: 22:45
 */

/**
 * Class NPackageProblem
 * 有n 个物品，它们有各自的重量，现有给定容量的背包，如何让背包里装入的物品具有最大的重量
 */
class NPackageProblem
{
    const MODE_RECURSIVE   = 1;
    const MODE_DP          = 2;
    const MODE_DP_OPTIMIZE = 3;
    
    /**
     * @param $nodes
     * @param $maxWeight
     * @param $packagesCount
     * @param $result
     * @param $tempResult
     */
    private function solveByRecursive($nodes, $maxWeight, &$result, $tempResult)
    {
        //如果所有的物品都装完了，或者是已经达到了最大重量，那么 over
        if (count($tempResult) == count($nodes) || array_sum($tempResult) == $maxWeight) {
            $result [] = $tempResult;
            
            return;
        }
        foreach ($nodes as $index => $node) {
            //已经用过这个物品了,或者包裹剩余重量不足以放这个物品
            if (isset($tempResult[$index]) || array_sum($tempResult) > ($maxWeight - $node)) {
                continue;
            }
            $tempResult [$index] = $node;
            
            $this->solveByRecursive($nodes, $maxWeight, $result, $tempResult);
            
            //不装这个物品
            unset($tempResult[$index]);
        }
    }
    
    /**
     * @param     $nodes
     * @param     $maxWeight
     * @param int $mode
     *
     * @return int
     * @throws \Exception
     */
    public function solve($nodes, $maxWeight, $mode = 1)
    {
        if ($mode == self::MODE_RECURSIVE) {
            $result = [];
            $this->solveByRecursive($nodes, $maxWeight, $result, []);
            
            rsort($result);
            
            return end($result);
        }
        
        if ($mode == self::MODE_DP) {
            return $this->solveByDP($nodes, $maxWeight);
        }
        
        if($mode == self::MODE_DP_OPTIMIZE){
            return $this->solveByDPOptimize($nodes, $maxWeight);
        }
        
        throw new \Exception("Unsupported Mode");
    }
    
    /**
     * 使用动态规划来处理背包问题。
     * 记录每一次放置或者不放置物品之后，可能的状态转移。
     *
     * @param       $nodes
     * @param       $maxWeight
     *
     * @return int
     */
    private function solveByDP($nodes, $maxWeight)
    {
        /**
         * 物品的状态转移表
         * [
         *   0 => [0,'',2,.....], //第0个物品放置或者是不放置之后的状态
         *   1 => [0,'',2,'',4,....], //第1个物品放置或者是不放置之后的状态,可能触达0,2,4
         *   ...
         *   length-1 => [....] //最后一个物品放置或者不放置之后的状态
         * ]
         */
        $status  = array_fill(0,count($nodes),array_fill(0,$maxWeight+1,false));
        $status[0][0] = true;
        $status[0][current($nodes)] = true;
        
        //依次考察所有的物品
        for ($row = 1; $row < count($nodes); $row++) {
            //不放置这个物品
            for($column=0;$column<=$maxWeight;$column++){
                $status[$row][$column] = $status[$row-1][$column];
            }
            //放置这个物品
            for($column=0;$column<=$maxWeight;$column++){
                //如果上一个物品的这个重量是可以触达的
                if($status[$row-1][$column]){
                    if($column + $nodes[$row] <= $maxWeight){
                        $status[$row][$column + $nodes[$row]] =  true;
                    }
                }
            }
        }
//        $this->printArray($status);
        $nodesCount = count($nodes);
        //因为最后一行包含了所有的可触达状态，所以使用最后一行的数据，从后往前看，哪一个是可以触达的，就返回他
        for($k=$maxWeight;$k>=0;$k--){
            if($status[$nodesCount-1][$k]){
                return $k;
            }
        }
        return 0;
    }
    
    private function printArray($status)
    {
        for($i=0;$i<count($status);$i++){
            echo "[";
            for($j=0;$j<count($status[$i]);$j++){
               echo intval($status[$i][$j]) ."\t";
            }
            echo "]\n";
        }
    }
    
    /**
     * @param $nodes
     * @param $maxWeight
     */
    private function solveByDPOptimize($nodes, $maxWeight)
    {
        $dp = array_fill(0,$maxWeight+1,false);
        $dp[0]= true;
        $dp[current($nodes)] = true;
        array_shift($nodes);
        foreach ($nodes as $node){
            //遍历之前的触达状态值
            for($i=count($dp)-1;$i>=0;$i--){
                if(!$dp[$i]){
                    continue;
                }
                echo "dp[$i]=".intval($dp[$i])."\t";
                //如果之前的状态触达了。并且加上当前的物品之后，新的状态仍然是合法的
                if(($i + $node) <= $maxWeight){
                    $dp[$i + $node] = true;
                }
            }
            echo "\n";
        }
        for($i=count($dp)-1;$i>=0;$i--){
            if($dp[$i]){
                return $i;
            }
        }
        return 0;
    }
}

$maxWeight = 9;
$nodes     = [2, 2, 4, 6, 3];

$solution = new  NPackageProblem();
$result   = $solution->solve($nodes, $maxWeight, NPackageProblem::MODE_DP_OPTIMIZE);
print_r($result);