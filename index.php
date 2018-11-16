<?php
/**
 * Created by PhpStorm.
 * User: sui
 * Date: 2018/11/14
 * Time: 18:18
 */

$arr = [
    [
        'questionId'      => 123,
        'courseSectionId' => 123,
    ],
    [
        'questionId'      => 12987979,
        'courseSectionId' => 123,
    ],
    [
        'questionId'      => 123998,
        'courseSectionId' => 0,
    ],
    [
        'questionId'      => 1239981283,
        'courseSectionId' => 0,
    ],
];

$arr =array_column($arr,null,'questionId');
print_r($arr ) ;

$arr = array_column($arr,'courseSectionId');
print_r($arr);

$arr=  array_unique($arr);
print_r($arr);
