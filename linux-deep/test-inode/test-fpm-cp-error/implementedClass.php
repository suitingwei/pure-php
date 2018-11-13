<?php
/**
 * Created by PhpStorm.
 * User: sui
 * Date: 2018/11/13
 * Time: 11:35
 */

require __DIR__.'/interface.php';

class TestClass implements  TestInterface {
    
    public function testEcho(string $text)
    {
        echo $text .PHP_EOL;
    }
}