<?php
/**
 * 测试在 fpm 运行中，cp 某一个文件导致的报错现象。
 * ---------------------------------------------
 */


require __DIR__.'/implementedClass.php';

while (true){
    $obj = new TestClass();
    $obj->testEcho("hello world");
    sleep(0.5);
}