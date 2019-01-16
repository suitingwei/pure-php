<?php
/**
 * 最基础的 socket server，只能同时处理一个请求
 */

//创建一个ipv4的tcp套接字
$sockFd = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

socket_bind($sockFd, '0.0.0.0', 8888);

socket_listen($sockFd);

while (true) {
    if (($connectFd = socket_accept($sockFd)) !== false) {
        $data = "Hello,client: the current time is:" . date('Y-m-d H:i:s', time());
        socket_write($connectFd, $data);
        
        //关闭 tcp 链接
        socket_close($connectFd);
    }
}
