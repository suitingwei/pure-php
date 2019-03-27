<?php
/**
 * Created by PhpStorm.
 * User: sui
 * Date: 2019-03-24
 * Time: 17:31
 */

class WordLadderProblemII
{
    private $minLength = null;
    
    /**
     * @param String   $beginWord
     * @param String   $endWord
     * @param String[] $wordList
     *
     * @return Integer
     */
    function ladderLength($beginWord, $endWord, $wordList)
    {
        $result = [];
        
        $this->bfs($beginWord, $endWord, $wordList, $result, []);
        
        return $this->minLength;
    }
    
    /**
     *
     *
     */
    function bfs($beginWord, $endWord, $wordList, &$result, $tempResult)
    {
        if ($beginWord == $endWord) {
            $tempResult [] = $endWord;
            $length        = count($tempResult);
            
            if ($length < $this->minLength || $this->minLength == null ) {
                $this->minLength = $length;
            }
            $result[] = $tempResult;
            
            return;
        }
        
        //循环尝试替换整个字符串的
        for ($i = 0; $i < strlen($beginWord); $i++) {
            $candicates = $this->generateSimirality($beginWord, $i);
            
            echo "BeginWord:{$beginWord},Candicates:" . json_encode($candicates) . PHP_EOL;
            foreach ($candicates as $candicate) {
                //如果这个字符不在合法字符集里，那么扔掉他.
                //如果这个字符已经用过了，也废掉他，因为如果重复再走这个字符，肯定路径会变长，而且也是没意义的。
                if (!in_array($candicate, $wordList) || in_array($candicate, $tempResult)) {
                    continue;
                }
                
                $tempResult[] = $candicate;
                
                $this->bfs($candicate, $endWord, $wordList, $result, $tempResult);
                
                array_pop($tempResult);
            }
        }
        
        return;
    }
    
    /**
     * 生成一个单词某一位转换之后的所有单词
     *
     */
    function generateSimirality($word, $index)
    {
        static $chars = [
            "a",
            "b",
            "c",
            "d",
            "e",
            "f",
            "g",
            "h",
            "i",
            "j",
            "k",
            "l",
            "m",
            "n",
            "o",
            "p",
            "q",
            "r",
            "s",
            "t",
            "u",
            "v",
            "w",
            "x",
            "y",
            "z"
        ];
        $result = [];
        foreach ($chars as $char) {
            $temp = $word;
            //不生成重复单词
            if ($temp[$index] == $char) {
                continue;
            }
            $temp[$index] = $char;
            $result []    = $temp;
        }
        
        return $result;
    }
}

$beginWord = "hit";
$endWord   = "cog";
$wordList  = ["hot", "dot", "dog", "lot", "log", "cog"];
$solution  = new WordLadderProblemII();

$solution->ladderLength($beginWord, $endWord, $wordList);
