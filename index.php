<?php

require './vendor/autoload.php';

$request = Kernel\Http\Src\Request::getInstance()->getQueryData();

(new Kernel\Application\Container(
    realpath(__DIR__)
))->run();

echo rootPath();


