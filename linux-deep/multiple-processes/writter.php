<?php
/**
 * This is a demo php script for testing the multiple fpm process file writting situtation.
 *
 * fpm
 *  |----- worker1 -------- writting log file
 *  |----- worker2 -------- writting log file
 *  |----- worker3 -------- writting log file
 *  |----- worker4 -------- writting log file
 */

$i        = 0;
$fileName = './single.file';
while ($i++ < 100) {
    $data = sprintf("time=%s,processId=%s,content=%s\n", date('Y-m-d H:i:s', time()), posix_getpid(), "This is the line{$i}");
    
    
    $fp = fopen($fileName, 'a+');
    
    if ($fp === false) {
        die('open file failed.');
    }
    
    //Get the exclusive lock on the file, so that only the current writter process can write the data into it.
    if (flock($fp, LOCK_EX)) {
        fwrite($fp, $data);
    }
    else{
        continue;
    }
    
    //release the lock on the file.
    flock($fp,LOCK_UN);
    
    sleep(0.1);
}



