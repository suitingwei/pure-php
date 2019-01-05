<?php
/**
 * Created by PhpStorm.
 * User: sui
 * Date: 2019/1/5
 * Time: 15:26
 */

$user = $largeArray = $moreLargeArray = null;

$user= apcuFetchOrAdd('user',['name'=>'sui']);
$largeArray = apcuFetchOrAdd('largeArry',range(1,100000));

return $largeArray;
function apcuFetchOrAdd($key,$data){
   if(apcu_exists($key)) {
       return apcu_fetch($key);
   }
   apcu_add($key,$data);
   return $data;
}
