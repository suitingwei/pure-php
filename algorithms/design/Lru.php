<?php

class DoubleListNode
{
    /**
     * 数据体
     *
     * @var string
     */
    public $val;
    
    /**
     * 数据的 key
     * 在 lru 之后，需要根据这个 key，从 hashMap 中移除这个元素的映射
     *
     * @var int
     */
    public $key;
    
    /**
     * 指向下一个元素
     *
     * @var \DoubleListNode
     */
    public $next;
    
    /**
     * @var \DoubleListNode
     */
    public $prev;
    
    
    public function __construct($key = null, $val = null)
    {
        $this->key = $key;
        $this->val = $val;
    }
}

class LRUCache
{
    
    /**
     * 核心数据容器
     * key => nodePoint
     *
     * @var array
     */
    private $hashMap;
    
    /**
     * 整个 lru 的容量上线
     *
     * @var integer
     */
    private $capacity;
    
    /**
     * 当前容器的使用长度
     *
     * @var int
     */
    private $length;
    
    /**
     * 头结点
     *
     * @var DoubleListNode
     */
    public $head;
    
    /**
     * 尾结点
     *
     * @var DoubleListNode
     */
    public $tail;
    
    /**
     * @param Integer $capacity
     */
    function __construct($capacity)
    {
        $this->capacity = $capacity;
        
        $this->head = new DoubleListNode(null);
        $this->tail = new DoubleListNode(null);
        
        $this->head->next = $this->tail;
        $this->head->prev = null;
        
        $this->tail->next = null;
        $this->tail->prev = $this->head;
    }
    
    /**
     * @param Integer $key
     *
     * @return Integer
     */
    function get($key)
    {
        if (isset($this->hashMap[$key])) {
            $node = $this->hashMap[$key];

//如果这个key 已经存在了，那么刷新他的节点状态，把这个节点放到第一个位置。
            $this->moveNodeToHead($node);
            
            return $node->val;
        }
        
        return -1;
    }
    
    /**
     * 需要考虑 put 相同 key 的元素。
     * 需要考虑是否达到了长度
     * @param Integer $key
     * @param Integer $value
     *
     * @return NULL
     */
    function put($key, $value)
    {
        //如果这个key 已经存在了，那么刷新他的节点状态，把这个节点放到第一个位置。
        if (isset($this->hashMap[$key])) {
            $node = $this->hashMap[$key];
            
            //如果是更新值，那么需要更新这个 node
            $node->val = $value;
            
            //移动到链表最前端
            $this->moveNodeToHead($node);
            
            return;
        }
        
        //如果是新的节点，那么判断有没有空间插入,如果没有空间，进行 lru，然后插入
        if ($this->length == $this->capacity) {
            $this->lru();
        }
        
        $node = $this->addToHead($key, $value);
        
        //记录到 hashMap
        $this->hashMap[$key] = $node;
        
        return;
        
    }
    
    /**
     * 进行lru操作
     *
     * @return null
     */
    function lru()
    {
        $lastNode = $this->tail->prev;
        
        //移除映射
        unset($this->hashMap[$lastNode->key]);
        
        //将结尾的 prev 指针，指向倒数倒数第二个节点
        $this->tail->prev = $this->tail->prev->prev;
        
        //将倒数第二个指针的 next 指向 tail
        $this->tail->prev->next = $this->tail;
        
        //修改链表长度
        $this->length--;
        
        return;
    }
    
    /**
     * 创建一个新节点，然后添加到头部
     *
     * @param Integer $value
     *
     * @return \DoubleListNode
     */
    function addToHead($key, $value)
    {
        $node = new DoubleListNode($key, $value);
        
        $node->next             = $this->head->next;
        $this->head->next->prev = $node;
        
        $this->head->next = $node;
        $node->prev       = $this->head;
        
        $this->length++;
        
        return $node;
    }
    
    /**
     * 移动一个新节点，然后添加到头部
     *
     * @param Integer $value
     *
     * @return \DoubleListNode
     */
    function moveNodeToHead(DoubleListNode $node)
    {
//从原地删除这个节点
        $node->prev->next = $node->next;
        $node->next->prev = $node->prev;

//添加到头部
        $node->next             = $this->head->next;
        $this->head->next->prev = $node;
        
        $this->head->next = $node;
        $node->prev       = $this->head;
        
        return $node;
    }
}


$capacity = 2;
$obj      = new LRUCache($capacity);
$obj->put(1, 1);
$obj->put(2, 2);
$obj->lru();
print_r($obj->head);
$obj->put(3, 2);
