<?php

/**
 * 回射客户端第二版。
 * 这个版本使用了 select 调用来实现同时监听STD_IO以及网络IO
 * But，因为 php 的socket_select实现上是不允许同时使用网络套接字和STDIO
 * 所以这个版本整体替换成了stream系列函数
 */

//关闭错误处理，不然 php 会抛出warning
//而其实我们已经做了异常处理了，这个就感觉很多余，比如socket_connect，如果超时的话，
//其实函数本身就返回false了，但是还是会抛出 warning
set_error_handler(function () {
});

pcntl_signal(SIGTERM, function () {

});

$server = $argv[1];
$port   = $argv[2];

$remoteAddress = "tcp://{$server}:{$port}";
$errorNo       = $errStr = null;

//创建一个链接,直接相当于socket,connect
$sockFd = stream_socket_client($remoteAddress, $errorNo, $errStr);

if (false === $sockFd) {
    die(sprintf("Failed to connect to the server:%s\nError:%s(%s)\n", $remoteAddress, $errStr, $errorNo));
}

/**
 * 同时监听标准输入以及网络 IO
 */
$originalReadFds   = [$sockFd, STDIN];
$writeFds          = [];
$exceptFds         = [];
$serverHasSendData = false;

while (true) {
    /**
     * 向标准输出给出提示语,因为在使用 select 调用的时候都是需要使用文件描述符。所以不能直接调用
     * `readline`之类的函数。这个时候需要我们手动模拟一发.
     */
    fwrite(STDOUT, "[Client]>");
    
    /**
     * 这一行很坑，因为select调用是会直接修改引用的。所以如果我们使用的都是$readFds，那么在 select 调用之后
     * `$readFds`都会变成第一次的触发读条件的文件描述符。那么在之后的循环中都是只能监听这些文件描述符了。所以
     * 我们需要使用一个额外的变量去记录要监听的读文件描述符。这样每一次循环进来的都是完整的要监听的。
     */
    $readFds = $originalReadFds;
    if (stream_select($readFds, $writeFds, $exceptFds, 50) === false) {
        die("socket_select() failed, reason: " . error_get_last());
    }
    
    /**
     * stream_select 函数返回之后，会直接修改引用。
     * 这里的readFds已经变成了出现 IO 变化的描述符，可以直接操作
     */
    foreach ($readFds as $readFd) {
        // 如果这次触发的读文件描述符是网络套接字。那么我们从 socket 中读取数据，并且输出到标准输出中
        if ($readFd == $sockFd) {
            $data = stream_socket_recvfrom($sockFd, 1024);
            fwrite(STDOUT, sprintf("\n[Server]> %s\n", $data));
        }
        // 如果这次触发的读文件描述符是标准输入。那么代表用户的键盘输出已经从硬件设备拷贝到了内核内存，又拷贝到了用户内存中。
        // 我们可以直接从标准输入中得到用户输入的具体数据,然后发送给网络套接字.
        elseif ($readFd == STDIN) {
            $data = strtolower(trim(fgets(STDIN)));
            if ($data == 'quit') {
                exit("Quitting...");
            }
            stream_socket_sendto($sockFd, $data);
        }
    }
}

echo "shutting down client\n";
fclose($sockFd);

