<?php
/**
 * Created by PhpStorm.
 * User: sui
 * Date: 2019/2/28
 * Time: 18:41
 */
$arr = [
    [1,2,3],
    [4,5,6],
    [7,8,9]
];

function rotate($matrix)
{
    $result = [];
    $length = count($matrix);
    for ($row = 0; $row < $length; $row++) {
        for ($column = 0; $column < $length; $column++) {
            $result[$row][$column] = $matrix[$length - 1 - $column][$row];
        }
    }
    return $result;
}

print_r(rotate($arr));