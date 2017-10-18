<?php

$associateArray = [
    'blue' => 1,
    'green' => 3,
    'yellow' => 5
];

$array2 = [
    'blue' => 2,
    'red' => 12,
    'green' => 5,
    'black' => 123
];

$pureArray = ['a', 'v', 's', 'qw'];


function testArrayKeysFunction($associateArray,$pureArray)
{
//Get the keys of the array
    print_r(array_keys($associateArray));

//Get the keys from the pure array.
    print_r(array_keys($pureArray));

//Get the keys which value equals the given parameter.
    print_r(array_keys($pureArray, 's'));

//If there is no value matches the given parameter, the empty array will be returned.
    print_r(array_keys($pureArray, 'q123'));

//The third optional parameter indicates whether use strict mode to compare the value.
    print_r(array_keys($associateArray, 1, true));

//There is no value strit equals
    print_r(array_keys($associateArray, '1', true));

}

function testArrayFillKeysFunction(){
    print_r(array_fill_keys(['a','b',123,'d','123213'],123));
}

function testArrayFillFunction(){
    print_r(array_fill(2,4,'qwe'));
    print_r(array_fill(-2,4,'qwe'));
}

function testArrayMapFunction(){
    print_r(array_map(function($value,$val2){
        return  $value * 2 . $val2;
    },[1,2,3,4],['a','b','c']));
}

function testArrayMergeFunction(){
    $arr1 = [1,2,3,4];
    $arr2 = [3,4,5,5,];

    //The numeric keys will be reindexing from zero.
    print_r(array_merge($arr1,$arr2));

    $arr1 = [
        'name' => 'Tom',
        'gender'=> 1,
        'age'=> 23,
        'qwe'=> 'qe'
    ];

    $arr2 = [
        'name'=> 'Gay',
        'gender'=> 2,
        'age'=> 23,
        'fucker'=> 123,
    ];

    //The string keys will use the last array values instead of the previous one.
    print_r(array_merge($arr1,$arr2));

    $data = [[1, 2], [3], [4, 5]];
    print_r(array_merge(... $data)); // [1, 2, 3, 4, 5];
}

//testArrayFillKeysFunction();
//testArrayFillFunction();
//testArrayMapFunction();

testArrayMergeFunction();


