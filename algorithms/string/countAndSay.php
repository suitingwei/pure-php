<?php

class Solution
{
    /**
     * 递归解决
     * 因为第 N 次的结果依赖于第N-1次的结果。
     * 所以我们使用递归的算法，这里可以假设已经有第N-1次结果，然后编写算法计算第 N 次即可
     */
    function countAndSay($n)
    {
        if ($n == 1) {
            return "1";
        }
        if ($n == 2) {
            return "11";
        }
        
        $previousResult = $this->countAndSay($n - 1);
        
        return $this->singleCalculate($previousResult);
    }
    
    /**
     * 使用临时变量来存储第i 次的结果，然后当遇到跟之前存储不一致的时候就把之前计算的结果取出来拼接
     *
     * @param string $previousResult
     *
     * @return string
     */
    function singleCalculate(string $previousResult)
    {
        $length = strlen($previousResult);
        
        /**
         * 临时存储相同的数字，然后计算数量
         * 比如说遍历1211这个数组，第一个元素是1，这个时候temp是空的，然后把1放进去
         */
        $tempArray = [];
        $result    = "";
        for ($i = 0; $i < $length; $i++) {
            $value = $previousResult[$i];
            //如果临时数组是空的,把这个值方进入，这个应对的是循环的开始
            if (empty($tempArray)) {
                $tempArray[$value] = 1;
            }
            //如果数组不是空的，判断这个元素，跟数组之前的元素是否相同,
            //如果是相同的元素，那么数量++，如果不是，证明这一段连续数字结束了，就可以给出这一段的结果了
            //并且要重新清空临时数组
            else {
                //这个数跟之前保存的不同
                if (!isset($tempArray[$value])) {
                    $number            = key($tempArray);
                    $count             = current($tempArray);
                    $result            .= "{$count}{$number}";
                    $tempArray         = [];
                    $tempArray[$value] = 1;
                } else {
                    $tempArray[$value]++;
                }
            }
        }
        
        if (!empty($tempArray)) {
            $number = key($tempArray);
            $count  = current($tempArray);
            $result .= "{$count}{$number}";
        }
        
        return $result;
    }
    
    
    /**
     * 遍历字符串，使用"相邻两个数字不相同"作为边界条件判 断
     *
     * @param string $previousResult
     *
     * @return string
     */
    function singleCalculateV2(string $str)
    {
        $k=-1;
        $result = "";
        for($i=0;$i<strlen($str);$i++){
            if($i== strlen($str)-1 || $str[$i]!=$str[$i+1]){
                $len=$i-$k;
                $k=$i;
                $result.=$len.$str[$i];
            }
        }
        return $result;
    }
}

echo (new Solution())->singleCalculateV2("11");

