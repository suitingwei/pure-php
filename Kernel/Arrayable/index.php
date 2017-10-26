<?php

namespace Arrayable;

use Arrayable\Src\Collection;

include './Src/Collection.php';


//print_r( Collection::create([false,null,'',-1,0,1,2,3,4])->map(function($val){
//    if(is_numeric($val)){
//        return $val *1 ;
//    }
//    return $val;
//})->filter(function($val){
//   return $val > 2;
//}));

//echo collection::create([1, 2, 3, 4])->average();
//echo collection::create([
//    ['foo'=> 1],
//    ['foo'=> 2],
//    ['foo'=> 3],
//    ['foo'=> 4],
//])->average('foo');
//print_r(Collection::create([
//    'name' => 'tom',
//    'age' => 12,
//    'address' => 'qwe',
//])->only('age','123','name')->except('age')->all());

//print_r(Collection::range(1,10)->chunk(3)->collapse()->combine(['a','b','c'])->all());
//
//var_dump(Collection::create(['name'=>'Tom','age'=>123])->contains('name'));

$collection = Collection::create([
    ['product' => 'Desk', 'price' => 200],
    ['product' => 'Chair', 'price' => 100],
    ['product' => 'Bookcase', 'price' => 150],
    ['product' => 'Door', 'price' => 100],
]);

print_r($collection->whereNotIn('price', [100, 200])->all());

print_r(true);
