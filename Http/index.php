<?php

include  './Src/Request.php';

$request =  new \Http\Src\Request();

print_r($request->url());
