<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
date_default_timezone_set("Asia/Shanghai");
$arr = [12,23,25,56,453,677,554,332,878,9907,66,5,8,3,23,56,54,78,89,907,43,22,16,87,98,67675,45,12,23,25,576786,78,89,653390,43,22,16,87,98,65,45,8,89,90,43,22,16,87,98,65,45,12,23,25,56,7812,23543,25,56,453,6377,554,332,878,9907,12266,5,5378,33123,23,56,56364,78,89,90,43];

/**
 * for foreach array_sum array_map array_reduce
 */
$count = count($arr);$num = 10000;
$sum = 0;$t1 = 0; $t2 = 0;


$t1 = microtime(true);
for($j = 0; $j < $num; $j++){
    for($i = 0; $i < $count; $i++){
        $sum += $arr["$i"];
    }
}
$t2 = microtime(true);
$d = bcsub($t2, $t1, 4);
echo 't2 '.$t2.' t1 '.$t1.' for '.$d.' sum= '.$sum.PHP_EOL;
$sum = 0;$t1 = 0; $t2 = 0;

$t1 = microtime(true);
for($j = 0; $j < $num; $j++){
    foreach($arr as $v){
        $sum += $v;
    }
}
$t2 = microtime(true);
$d = bcsub($t2, $t1, 4);
echo 't2 '.$t2.' t1 '.$t1.' foreach '.$d.' sum= '.$sum.PHP_EOL;
$sum = 0;$t1 = 0; $t2 = 0;

$t1 = microtime(true);
$callback = function($v){
    return $v+$v;
};
for($j = 0; $j < $num; $j++){
    $r = array_map($callback, $arr);
}
$t2 = microtime(true);
$d = bcsub($t2, $t1, 4);
echo 't2 '.$t2.' t1 '.$t1.' array_map '.$d.' sum= '.$sum.PHP_EOL;
$sum = 0;$t1 = 0; $t2 = 0;

$t1 = microtime(true);
$callback3 = function($sums,$v){
    $sums += $v;
    return $sums;
};
for($j = 0; $j < $num; $j++){
    $v = array_reduce($arr, $callback3);
    $sum += $v;
}
$t2 = microtime(true);
$d = bcsub($t2, $t1, 4);
echo 't2 '.$t2.' t1 '.$t1.' array_reduce '.$d.' sum= '.$sum.PHP_EOL;
$sum = 0;$t1 = 0; $t2 = 0;

$t1 = microtime(true);
for($j = 0; $j < $num; $j++){
    $sum += array_sum($arr);
}
$t2 = microtime(true);
$d = bcsub($t2, $t1, 4);
echo 't2 '.$t2.' t1 '.$t1.' array_sum '.$d.' sum= '.$sum.PHP_EOL;
$sum = 0;$t1 = 0; $t2 = 0;


