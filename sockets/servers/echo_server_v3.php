<?php
/**
 * 回射服务器第三版。
 * 这个版本的回射服务器基于select系统调用实现，始终使用单进程处理请求。
 * 但是基于 IO 复用来提高并发能力。
 */

$address = $argv[1] ?? die("Address number required!");
$port    = $argv[2] ?? die("Port number required!");

$remoteAddress = "tcp://{$address}:{$port}";
$errorNo       = $errStr = null;

//创建一个ipv4的tcp套接字
$sockFd = stream_socket_server($remoteAddress,$errorNo,$errStr);

if($sockFd === false){
    die("Failed to create socket server\n");
}

/**
 * 监听读文件描述符，最初只有监听套接字。
 */
$connections = [$sockFd];
$writeFds    = $exceptFds = [];

while (true) {
    $readFds = $connections;
    
    /**
     * 监听所有的文件描述符的事件.
     */
    if (stream_select($readFds, $writeFds, $exceptFds, 5) === false) {
        die("Socket select error");
    }
    
    foreach ($readFds as $readFd) {
        //如果是监听套接字上来到了新的读请求。那么证明这是来了链接了。
        if ($readFd == $sockFd) {
            //接受新的请求
            $newConnection = stream_socket_accept($sockFd);
            
            //将新的请求放置到connections数组中
            $connections [] = $newConnection;
        } //如果不是监听套接字发来了请求，那么就是其他普通的请求发来了请求了。
        else {
            $data = stream_socket_recvfrom($readFd, 1024);
            stream_socket_sendto($readFd,$data);
        }
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


