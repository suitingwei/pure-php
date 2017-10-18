<?php
/**
 * Created by PhpStorm.
 * User: sui
 * Date: 2017/10/12
 * Time: 13:34
 */

for ($i =0 ; $i  < 5; $i++){
    for ($j =0; $j<5; $j++){
        if($j==2){
            continue 2;
        }
        print 'i=:'.$i ."\t"."j=:".$j.PHP_EOL;
    }
}


echo "include not existed file will not crash";