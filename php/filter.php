<?php

/* 
 * filter 过滤器函数
 * PHP 过滤器用于验证和过滤来自非安全来源的数据。
 * 验证和过滤用户输入或自定义数据是任何 Web 应用程序的重要组成部分。
 * 设计 PHP 的过滤器扩展的目的是使数据过滤更轻松快捷。
 * 
 * 来自表单的输入数据
 * Cookies
 * 服务器变量
 * 数据库查询结果
 * 
 * 有两种过滤器：
 * Validating 过滤器：  //验证变量
 *      用于验证用户输入
 *      严格的格式规则（比如 URL 或 E-Mail 验证）
 *      如果成功则返回预期的类型，如果失败则返回 FALSE
 * Sanitizing 过滤器：   //删除字符
 *      用于允许或禁止字符串中指定的字符
 *      无数据格式规则
 *      始终返回字符串
 * 
 * filter_has_var — 检测是否存在指定类型的变量
 * filter_id — 返回与某个特定名称的过滤器相关联的id
 * filter_input_array — 获取一系列外部变量，并且可以通过过滤器处理它们
 * filter_input — 通过名称获取特定的外部变量，并且可以通过过滤器处理它
 * filter_list — 返回所支持的过滤器列表
 * filter_var_array — 获取多个变量并且过滤它们
 * filter_var — 使用特定的过滤器过滤一个变量
 */

/**
 * 输出
 * @param type $msg
 * @param type $flag
 */
function e($msg, $t = '',$flag = 1){
    if($t == 0 || !empty($t)){
        echo $t.' = ';
    }
    if($flag == 1){
        var_dump($msg);
    }else if($flag == 2){
        echo $msg;
    }
    echo '<br />';
    unset($GLOBALS['r']);
}

echo "filter.php?t1=12&t2&t3=abcd<br />";
echo "1.<br />";
//bool filter_has_var ( int $type , string $variable_name )检测是否存在指定类型的变量
//type  INPUT_GET、 INPUT_POST、 INPUT_COOKIE、 INPUT_SERVER、 INPUT_ENV 里的其中一个。
//不支持现场赋值
$r = filter_has_var(INPUT_GET, 't1'); e($r, "filter_has_var(INPUT_GET, 't1')");
$r = filter_has_var(INPUT_GET, 't2'); e($r, "filter_has_var(INPUT_GET, 't2')");

echo "2.<br />";
//int filter_id ( string $filtername )返回与某个特定名称的过滤器相关联的id
$r = filter_id('int'); e($r, "filter_id('int')");
$r = filter_id('ints'); e($r, "filter_id('ints')");

echo "3.<br />";
//array filter_list ( void )
//返回一个所支持的过滤器的名称的列表，如果没有这样子的过滤器的话则返回空数组。
//这个数组的索引不是过滤器id， 你可以通过 filter_id() 去根据名称获取它们。
$r1 = $r = filter_list(); //e($r, "filter_list()");
foreach ($r1 as $v){
     $r = filter_id($v); e($r, "filter_id($v)");
}

echo "4.<br />";
//mixed filter_input ( int $type , string $variable_name [, int $filter = FILTER_DEFAULT [, mixed $options ]] )
// 通过名称获取特定的外部变量，并且可以通过过滤器处理它
//$filter 可选。规定要使用的过滤器的 ID。默认是 FILTER_SANITIZE_STRING。
//请参见完整的 PHP Filter 函数参考手册，获得可能的过滤器。
//过滤器 ID 可以是 ID 名称 （比如 FILTER_VALIDATE_EMAIL），或 ID 号（比如 274）。
//options	规定包含标志/选项的数组。检查每个过滤器可能的标志和选项。
//如果成功的话返回所请求的变量。如果过滤失败则返回 FALSE ，如果variable_name 不存在的话则返回 NULL 。
$r = filter_input(INPUT_GET, 't1'); e($r, "filter_input(INPUT_GET, 't1')");
$r = filter_input(INPUT_GET, 't1', 513); e($r, "filter_input(INPUT_GET, 't1',513)");
$r = filter_input(INPUT_GET, 't2'); e($r, "filter_input(INPUT_GET, 't2')");
$r = filter_input(INPUT_GET, 't3'); e($r, "filter_input(INPUT_GET, 't3')");
$r = filter_input(INPUT_GET, 't4'); e($r, "filter_input(INPUT_GET, 't4')");

$r = filter_input(INPUT_GET, 't1', FILTER_SANITIZE_EMAIL); e($r, "filter_input(INPUT_GET, 't1', FILTER_SANITIZE_EMAIL)");
$r = filter_input(INPUT_GET, 't1', FILTER_VALIDATE_EMAIL); e($r, "filter_input(INPUT_GET, 't1', FILTER_VALIDATE_EMAIL)");
echo "5.<br />";
//mixed filter_var ( mixed $variable [, int $filter = FILTER_DEFAULT [, mixed $options ]] )
//使用特定的过滤器过滤一个变量
$r = filter_var('1213@qq.com', FILTER_VALIDATE_EMAIL); e($r, "filter_var('1213@qq.com', FILTER_VALIDATE_EMAIL)");
$r = filter_var('1213@qq', FILTER_VALIDATE_EMAIL); e($r, "filter_var('1213@qq', FILTER_VALIDATE_EMAIL)");


echo "<br />";
$num = 10000;
$t1 = 0; $t2 = 0;
$r = '12323isfdsi@qq.com';
$p = '/\w[-\w.+]*@([A-Za-z0-9][-A-Za-z0-9]+\.)+[A-Za-z]{2,14}/';

//1
$t1 = microtime(true);
for($j = 0; $j < $num; $j++){
    filter_var($r, FILTER_VALIDATE_EMAIL);
}
$t2 = microtime(true);
$d = bcsub($t2, $t1, 4);
echo 'filter_var1 '.$d."<br />";
$t1 = 0; $t2 = 0;

//1
$t1 = microtime(true);
for($j = 0; $j < $num; $j++){
    preg_match($p, $r);
}
$t2 = microtime(true);
$d = bcsub($t2, $t1, 4);
echo 'preg_match1 '.$d."<br />";
$t1 = 0; $t2 = 0;










