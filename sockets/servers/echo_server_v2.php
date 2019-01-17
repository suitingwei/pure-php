<?php
/**
 * 使用 fork 来实现的回射服务器
 * 这个版本的服务器可以同时伺服多个客户端链接.
 * 使用每一个子进程去处理一个链接。
 */

$address = $argv[1] ?? die("Address number required!");
$port    = $argv[2] ?? die("Port number required!");

/**
 * 安装信号量
 */
installSignal();

//创建一个ipv4的tcp套接字
$sockFd = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

socket_bind($sockFd, $address, $port);

//4000[二次握手] 6000[三次握手]
socket_listen($sockFd, 10000);

while (true) {
    //三次握手完成,取出来第一个三次握手成功的
    if (($connectFd = socket_accept($sockFd)) === false) {
        die("Failed to accept the client connection" . socket_last_error());
    }
    
    $pid = pcntl_fork();
    
    /**
     * 子进程
     */
    if ($pid == 0) {
        //子进程关闭监听套接字
//        socket_close($sockFd);
        
        while (!empty($clientData = socket_read($connectFd, 1024))) {
            echo sprintf("[Client]> %s\n", $clientData);
            socket_write($connectFd, $clientData);
        }
        
        /**
         * 如果客户端发送了空字符串，那么我们视为他想要结束链接。就关闭这个链接套接字
         */
        socket_close($connectFd);
    } /**
     * 父进程继续处于 while 大循环即可
     * 如果 php 的 cli 模式没有做特殊的机制的话。
     * 那么进行 fork 之后，父子进程都将拥有一份相同的文件描述符。 这个会让操作系统的全局打开文件描述符的计数器+1,
     * 那么最后当子进程关闭连接的时候，其实这个套接字文件描述符的引用还有1（父进程）。所以其实操作系统并不会进行四次挥手
     * 所以父进程需要关闭连接套接字；子进程需要关闭监听套接字。
     */
    else {
//        socket_close($connectFd);
    }
}

function installSignal()
{
    pcntl_signal(SIGTERM, function () {
        echo "Receiving signal term\n";
        exit(0);
    });
}
