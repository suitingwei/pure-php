<?php
/**
 * Created by PhpStorm.
 * User: sui
 * Date: 2019/3/28
 * Time: 14:54
 */

class CoinChangeProblem
{
    
    private function solveByRecursive($coins, $amount, &$result, $tempResult)
    {
        if (array_sum($tempResult) > $amount) {
            return;
        }
        
        if (array_sum($tempResult) == $amount) {
            $temp = $tempResult;
            sort($temp);
            $hashKey = implode($temp);
            if (!isset($result[$hashKey])) {
                $result [$hashKey] = $tempResult;
            }
            
            return;
        }
        foreach ($coins as $coin) {
            $tempResult[] = $coin;
            $this->solveByRecursive($coins, $amount, $result, $tempResult);
            array_pop($tempResult);
        }
        
        return;
    }
    
    /**
     * @param Integer[] $coins
     * @param Integer   $amount
     *
     * @return array
     */
    function coinChange($coins, $amount)
    {
//        $result = [];
//        $this->solveByRecursive($coins, $amount, $result, []);
//
//        return $result;
        return $this->solveByDP($coins, $amount);
    }
    
    /**
     * 使用动态规划
     *
     * @param array $coins
     * @param int   $amount
     *
     * @return int|mixed
     */
    private function solveByDP($coins, $amount)
    {
        //记录每一个币种的可达值,这里初始化的长度为amount+1,因为我们不用下标0，那样计算太麻烦了。就用下标 i 表示 i 元。
        $dp = array_fill(0, $amount + 1, -1);
        
        //初始化币种的可达值,这里一定要小心，到底这个值能不能触达，因为有可能目标值比币种还小。
        //比如给的币种是:5,8,10,目标是4，那这些值其实都算是不可触达
        foreach ($coins as $coin) {
            if ($coin <= $amount) {
                $dp[$coin] = 1;
            }
        }
        
        for ($i = 1; $i <= $amount; $i++) {
            //如果这个状态还没有触达，那么就忽略.
            if ($dp[$i] == -1) {
                continue;
            }
            
            //本来一开始以为是从大币种开始计算的，但是实际上发现币种的使用顺序没什么大影响。
            //因为贪心的求解不一定是整体最优解
            for ($j = count($coins) - 1; $j >= 0; $j--) {
                //用上一次的金币 + 这一次金币作为新的下标
                $newIndex = $i + $coins[$j];
                
                //如果新下标，也就是金币总和超过了目标值，那么就略过了
                if ($newIndex > $amount) {
                    continue;
                }
                
                //如果这个新坐标还没有被标记，记录这个值的次数
                if ($dp[$newIndex] == -1) {
                    $dp[$newIndex] = $dp[$i] + 1;
                } else {
                    //这里最重要了。因为达到了这个总和的路径不一定是最小值。所以每一次都需要判断一下。
                    //举例来说：比如给定货币[408,419,80]，然后目标是 419*10+400,用419前期虽然很快
                    //但是到达4190之后只能用小的数字去拼凑。而用408虽然前期可能略慢，但是后期可能更快
                    //上述这个例子可能不是很准，但是整体大概就是这个原因，所以必须每次都判断一下
                    $dp[$newIndex] = min($dp[$newIndex], $dp[$i] + 1);
                }
            }
        }
        
        return end($dp) != -1 ? end($dp) : -1;
    }
    
}

$solution = new CoinChangeProblem();

$coins  = [186, 419, 83, 408];
$amount = 6249;

var_dump($solution->coinChange($coins, $amount));

