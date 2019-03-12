<?php
/**
 * Created by PhpStorm.
 * User: sui
 * Date: 2019/3/10
 * Time: 10:39
 */

/**
 * Class PalindromePartitioning
 * 回文字符串分割
 * @link https://leetcode-cn.com/problems/palindrome-partitioning/
 */
class PalindromePartitioning
{

    /**
     * 分割回文串。
     * 用回溯算法，从头开始一个一个找回文串，由短到长，然后截取这一段，用剩下的串继续操作
     * @param       $str
     * @param array $result
     * @param array $tempResult
     * @return bool
     */
    function slove($str, array &$result, array $tempResult)
    {
        echo sprintf("String:%s,\tTempResult:%s,\tResult:%s\n",
            $str,
            json_encode($tempResult),
            json_encode($result)
        );
        if (empty($str)) {
            if (!empty($tempResult)) {
                $result[] = $tempResult;
            }
            return true;
        }

        for ($i = 0; $i < strlen($str); $i++) {
            $tempStr = substr($str, 0, $i + 1);
//            echo "Slice substring:".$tempStr.PHP_EOL;

            //如果从0-i为止的子串不是回文，那么继续往后探索
            if (!$this->isPalindromeStr($tempStr)) {
//                echo sprintf("String:%s is not palindrome.\n",$tempStr);
                continue;
            }

            //临时结果放入
            $tempResult [] = $tempStr;

            //探索从i+1往后的字符串
            $ret = $this->slove(substr($str, $i + 1), $result, $tempResult);

            if ($ret === false) {
                array_pop($tempResult);
            }
        }
        return false;
    }

    /**
     * 是否是回文
     * @param $tempStr
     * @return bool
     */
    private function isPalindromeStr($tempStr)
    {
        if (empty($tempStr)) {
            return false;
        }
//        echo "Validating palindrome string:{$tempStr}\n";
        $i = 0;
        $j = strlen($tempStr) - 1;

        while ($i <= $j) {
            if ($tempStr[$i] !== $tempStr[$j]) {
                return false;
            }
            $i++;
            $j--;
        }
        return true;
    }

    function partition($str)
    {
        $result = [];
        $this->slove($str, $result, []);
        return $result;
    }
}


$result = (new PalindromePartitioning())->partition("aab");

print_r($result);
