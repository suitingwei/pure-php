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

$i = 0;
while($i++<100){
    $data=  sprintf("time=%s,processId=%s,content=%s\n",date('Y-m-d H:i:s',time()),posix_getpid(),"This is the line{$i}");
    
    echo $data;
    file_put_contents('./single.file',$data,FILE_APPEND);
    
    sleep(0.1);
}



