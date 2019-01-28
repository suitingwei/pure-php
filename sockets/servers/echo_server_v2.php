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

/**
 * 设置主监听套接字为非阻塞状态。
 * 这样如果有信号量到达的时候，accept 调用会返回 false，主循环下一次能够检测到。
 */
socket_set_nonblock($sockFd);

//4000[二次握手] 6000[三次握手]
socket_listen($sockFd, 10000);

while (true) {
    
    /**
     * 如果在上一次循环中，accept 调用的时候出发了信号量，那么会阻塞？排队？
     * 不会排队的，unix 信号量如果在发送的时候
     * 需要手动再次触发已经达到的信号量
     */
    pcntl_signal_dispatch();
    
    /**
     * 三次握手完成,取出来第一个三次握手成功的
     * 1. 在阻塞 SOCKET 调用的时候，这个函数会在没有连接到来的情况下永久阻塞，直到第一个请求到来。
     * 即便内核触发了信号量，因为进程阻塞在这一个系统调用，也不会停止。
     * 2.所以必须设置 socket 为非阻塞调用，这样如果没有连接，那么 accept会返回 false。在 C 中
     * 如果收到了信号量，那么 accept 调用可能直接回返回E_INT错误码。可以直接捕获。
     */
    if (($connectFd = socket_accept($sockFd)) === false) {
        //die("Failed to accept the client connection" . socket_last_error());
        //监听套接字刚刚建立的时候，还没有请求到达，这个时候会直接返回 false 表示无请求。
        continue;
    }
    
    $pid = pcntl_fork();
    
    /**
     * 子进程
     */
    if ($pid == 0) {
        //子进程关闭监听套接字
        socket_close($sockFd);
        
        /**
         * Socket read 函数会阻塞在这里。
         * 即便网络连接上没有数据传送，这个函数也是会停在这里.
         * 直到客户端发送了一个空的数据包（也就是说有 header，但是 data 是空）
         */
        while (!empty($clientData = socket_read($connectFd, 1024))) {
            echo sprintf("[Client]> %s\n", $clientData);
            socket_write($connectFd, $clientData);
        }
        
        /**
         * 如果客户端发送了空字符串，那么我们视为他想要结束链接。就关闭这个链接套接字
         */
        socket_close($connectFd);
        
        //子进程退出
        exit(0);
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

/**
 *
 */
function installSignal()
{
    if (pcntl_signal(SIGTERM, 'handleMasterTerminate') === false) {
        die("Failed to install signal SIGTERM \n" . error_get_last()['message'] ?? '');
    } else {
        echo "Installing signal:[SIGTERM]\n";
    }
    
    if (pcntl_signal(SIGINT, 'handleMasterTerminate') === false) {
        die("Failed to install signal SIGTERM \n" . error_get_last()['message'] ?? '');
    } else {
        echo "Installing signal:[SIGTERM]\n";
    }
    
    if (pcntl_signal(SIGCHLD, 'handleChildExit') === false) {
        die("Failed to install signal SIGCHILD \n" . error_get_last()['message'] ?? '');
    } else {
        echo "Installing signal:[SIGCHILD]\n";
    }
}

/**
 * @param int $signalNumber
 * @param     $signalInfo
 */
function handleMasterTerminate(int $signalNumber, $signalInfo)
{
    echo "Receiving signal term!\n";
    exit(0);
}

function handleChildExit(int $signalNumber, $signalInfo)
{
    $status = 0;
    
    /**
     * 如果有一个子进程退出了。会触发这个信号 handler，然后进入一次循环，然后他一定能找到一个刚才退出的子进程
     */
    while (($pid = pcntl_wait($status, WNOHANG)) > 0) {
        echo sprintf("Child process:%s has exited with status:%s\n", $pid, $status);
    }
    
    return;
}
