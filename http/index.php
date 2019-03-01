<?php

//header("HTTP/1.1 404 Not Found",true,404);
//这里的空行就是输出了，也是弄不明表
//sendHeader();
echo json_encode([]);

header("Content-Type: application/json");
header("HTTP/1.1 500 Internal Server Error",true,500);
function sendHeader(){
    //这里的空行不是输出哦
    header("HTTP/1.1 404 Not Found",true,404);
}
function sendRedirect(){
    header('Location: http://wordpress.alone-night.top');
}
