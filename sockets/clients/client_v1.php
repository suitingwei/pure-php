<?php

//关闭错误处理，不然 php 会抛出warning
//而其实我们已经做了异常处理了，这个就感觉很多余，比如socket_connect，如果超时的话，
//其实函数本身就返回false了，但是还是会抛出 warning
set_error_handler(function(){});

$server = $argv[1];
$port   = $argv[2];

//创建一个ipv4的tcp套接字
$sockFd = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

//连接服务器
if (socket_connect($sockFd, $server, $port) === false) {
    die("Failed to connect to server:{$server},port:{$port}");
}

//从服务端读取数据,这里
while (!empty($data = socket_read($sockFd, 1024))) {
    echo sprintf("Reading data from server:\n%s\n", $data);
}

socket_close($sockFd);

