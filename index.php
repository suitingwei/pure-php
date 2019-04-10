<?php

require __DIR__ . '/vendor/autoload.php';




$nums = ['a','b','c'];

foreach($nums as $key => $value){
    //value => a ,
		$value = &$nums[$key];
		var_dump($nums);
}
