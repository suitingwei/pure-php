<?php
/**
 * Created by PhpStorm.
 * User: sui
 * Date: 2018/11/12
 * Time: 17:44
 */

$fileName = 'shared.file';
$filePath = __DIR__ . DIRECTORY_SEPARATOR . $fileName;

//如果有跑过的文件，删除
if(is_file($filePath)){
    unlink($filePath);
}
//创建新文件
touch($filePath);

echo "start writing the file {$fileName}\n";

$fp = fopen($filePath,'a');

$lineNumber = 1;
while (true) {
    fwrite($fp, "====line{$lineNumber}====\n");
    
    $lineNumber++;
    
    sleep(0.5);
}
fclose($fp);
