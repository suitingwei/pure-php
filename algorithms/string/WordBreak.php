<?php
/**
 * Created by PhpStorm.
 * User: sui
 * Date: 2019/3/10
 * Time: 20:19
 */

/**
 * Class WordBreakProblem
 * 单词拆分
 * @link https://leetcode-cn.com/problems/word-break/
 */
class WordBreakProblem
{
    function slove($str)
    {

    }

    /**
     * @param       $s
     * @param array $wordDict
     * @return bool
     */
    function wordBreak($s, array $wordDict)
    {
        if(empty($s)){
            return true;
        }

        foreach ($wordDict as $index => $word) {
            $pos = strpos($s, $word);
            //如果这个子串在原字符串根本不连续出现，那么久不用看了
            if($pos === false){
                unset($wordDict[$index]);
                continue;
            }
            $newStr= str_replace($word,' ',$s);

            $ret = $this->wordBreak($newStr,$wordDict);

            if($ret === true){
                return true;
            }
        }
        return false;
    }
}


//$s = "applepenapple";
//$wordDict = ["apple", "pen"];
//$s = "catsandog";
//$wordDict = ["cats", "dog", "sand", "and", "cat"];
//$s = "cars";
//$wordDict = ["car","ca","rs"];
$s = "ccbb";
$wordDict= ['cb','bc'];
var_dump( (new WordBreakProblem())->wordBreak($s,$wordDict));