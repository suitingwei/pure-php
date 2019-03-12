<?php
/**
 * Created by PhpStorm.
 * User: sui
 * Date: 2019/3/9
 * Time: 20:46
 */

/**
 * Class ValidBinarySearchTree
 * @link https://leetcode-cn.com/explore/interview/card/top-interview-questions-easy/7/trees/48/
 * 验证二叉搜索树
 */
class ValidBinarySearchTree
{
    /**
     * 
     * 根据中序遍历，二叉搜索树是一个递增数组
     */
    function solution($root)
    {
        $stack = [];
        $this->middleOrderTraverse($root, $stack);

        if (count($stack) == 1) {
            return true;
        }

        for ($i = 1; $i < count($stack); $i++) {
            if ($stack[$i] <= $stack[$i - 1]) {
                return false;
            }
        }
        return true;
    }


    function middleOrderTraverse($root, &$stack)
    {
        if (empty($root)) {
            return;
        }
        $this->middleOrderTraverse($root->left,$stack);
        $stack [] = $root->val;
        $this->middleOrderTraverse($root->right,$stack);
    }

}