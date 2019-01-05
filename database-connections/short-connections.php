<?php

$arr = [];

//unix socket, tcp
for ($i = 0; $i<100;$i++){
    $arr[] = new PDO('mysql:host=127.0.0.1;dbname=test;','root','root');
}


sleep(10);



