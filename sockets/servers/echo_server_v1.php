<?php
/**
 * 第一版本回射服务器
 * 这个服务器还是单进程模型,并且只能同时处理一个请求
 */

//创建一个ipv4的tcp套接字
$sockFd = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

socket_bind($sockFd, '0.0.0.0', 8888);

socket_listen($sockFd);

while (true) {
    if (($connectFd = socket_accept($sockFd)) === false) {
        die("Failed to accept the client connection" . socket_last_error());
    }
    
//    $data = "Hello,client: the current time is:" . date('Y-m-d H:i:s', time());
//    socket_write($connectFd, $data);
    
    while (!empty($clientData = socket_read($connectFd, 1024))) {
        echo sprintf("[Client]> %s\n",$clientData);
        socket_write($connectFd, $clientData);
    }
    
    echo "Shutting down the server.\n";
    //关闭 tcp 链接
    socket_close($connectFd);
}
