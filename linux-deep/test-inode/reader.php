<?php
/**
 * Created by PhpStorm.
 * User: sui
 * Date: 2018/11/12
 * Time: 17:44
 */

$fileName = 'shared.file';
$filePath = __DIR__ . DIRECTORY_SEPARATOR . $fileName;

echo "start reading the file {$fileName}\n";

$fp = fopen($filePath,'a');

if($fp === false){
   die('failed to open the file') ;
}

while (true) {
    $line = fread($fp,1000);
    
    echo "data read= \t".$line.PHP_EOL;
    
    sleep(0.5);
}
fclose($fp);
