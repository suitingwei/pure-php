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

$fileName = './single.file';

$fp = fopen($fileName, 'a+');

if ($fp === false) {
    die('open file failed.');
}

$lock = false;

//Get the exclusive lock on the file, so that only the current writter process can write the data into it.
while(!($lock = flock($fp,LOCK_EX))){
    echo "failed to get the clusive lock on the file.\n";
    sleep(0.1);
}

for($i=0;$i<100;$i++){
    
    $data = sprintf("time=%s,processId=%s,content=%s\n", date('Y-m-d H:i:s', time()), posix_getpid(), "This is the line{$i}");
    
    echo $data;
    
    fwrite($fp,$data);
    
    sleep(0.1);
}


//release the lock on the file.
flock($fp,LOCK_UN);


