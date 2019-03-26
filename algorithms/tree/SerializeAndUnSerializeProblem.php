<?php
/**
 * Created by PhpStorm.
 * User: sui
 * Date: 2019/3/26
 * Time: 12:01
 */

class ListNode
{
    public $left;
    public $right;
    public $val;
    
    public function __construct($value)
    {
        $this->val = $value;
    }
}

/**
 * Class SerializeAndUnSerializeProblem
 *
 * @link https://leetcode-cn.com/problems/serialize-and-deserialize-bst/
 * @link https://leetcode-cn.com/problems/serialize-and-deserialize-binary-tree/
 * 使用前序遍历来序列化和反序列化
 */
class SerializeAndUnSerializeProblem
{
    // Encodes a tree to a single string.
    public function serialize($root)
    {
        if ($root == null) {
            return "#,";
        }
        $result = "{$root->val},";
        
        $result .= $this->serialize($root->left);
        $result .= $this->serialize($root->right);
        
        return $result;
    }
    
    // Decodes your encoded data to tree.
    public function deserialize($data)
    {
        $nodes = explode(',', $data);
        
        return $this->build($nodes);
    }
    
    /**
     * @param array $nodes
     *
     * @return \ListNode|null
     */
    public function build($nodes)
    {
        $nodeValue = array_shift($nodes);
        if ($nodeValue == '#') {
            return null;
        }
        $node        = new ListNode($nodeValue);
        $node->left  = $this->build($nodes);
        $node->right = $this->build($nodes);
        
        return $node;
    }
}