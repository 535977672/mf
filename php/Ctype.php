<?php

/* 
 * 该扩展所提供的函数用来检测 在当前的区域设定下（参见 setlocale()），一个字符或者字符串 是否仅包含指定类型的字符。
 * 需要提醒的是，如果可以满足需求，请优先考虑使用 ctype 函数， 
 * 而不是正则表达式或者对应的 "str_*" 和 "is_*" 函数。 
 * 因为 ctype 使用的是原生 C 库，所以会有明显的性能优势。
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

//bool ctype_alnum ( string $text )
//检查提供的string,text 是否全部为字母和(或)数字字符。
$r = ctype_alnum(1234); e($r, "ctype_alnum(1234)");
$r = ctype_alnum('REEdds'); e($r, "ctype_alnum('REEdds')");
$r = ctype_alnum('123FDS'); e($r, "ctype_alnum('123FDS')");

echo "<br />";
//bool ctype_alpha ( string $text )做纯字符检测
//在标准的 C 语言环境下，字母仅仅是指 [A-Za-z] ， ctype_alpha() 等同于 (ctype_upper($text) || ctype_lower($text)) 
$r = ctype_alpha('REEdds'); e($r, "ctype_alpha('REEdds')");
$r = ctype_alpha('REEdds1'); e($r, "ctype_alpha('REEdds1')");
$r = ctype_alpha(82); e($r, "ctype_alpha(82)");

echo "<br />";
//bool ctype_cntrl ( string $text ) 是不是都是控制字符。例如：换行、缩进、空格
$r = ctype_cntrl('REEdds'); e($r, "ctype_cntrl('REEdds')");
$r = ctype_cntrl("\n\t\r"); e($r, "ctype_cntrl(\"\\n\\t\\r\")");

echo "<br />";
//bool ctype_digit ( string $text ) 字符是不是都是数字。
$r = ctype_digit('REEdds'); e($r, "ctype_digit('REEdds')");
$r = ctype_digit('123'); e($r, "ctype_digit('123')");
$r = ctype_digit(123); e($r, "ctype_digit(123)");
$r = ctype_digit('12.3'); e($r, "ctype_digit('12.3')");

echo "<br />";
//bool ctype_graph ( string $text ) 做可打印字符串检测，空格除外。 字符输出都是可见的 没有空白。
$r = ctype_graph("12.3\n"); e($r, "ctype_graph(\"12.3\\n\")");
$r = ctype_graph('12. 3'); e($r, "ctype_graph('12. 3')");
//bool ctype_print ( string $text )
//字符都能被实际输出（包括空白），就返回 TRUE ；如果包含控制字符或者那些根本不会有任何输出的字符串，就返回 FALSE 。
$r = ctype_print("12.3\n"); e($r, "ctype_print(\"12.3\\n\")");
$r = ctype_print('12. 3'); e($r, "ctype_print('12. 3')");


echo "<br />";
//bool ctype_lower ( string $text )
//bool ctype_upper ( string $text )
$r = ctype_lower("abc"); e($r, "ctype_lower(\"abc\")");
$r = ctype_lower("abc1"); e($r, "ctype_lower(\"abc1\")");
$r = ctype_lower(82); e($r, "ctype_lower(82)");
$r = ctype_upper('ABC'); e($r, "ctype_upper('ABC')");
$r = ctype_upper(82); e($r, "ctype_upper(82)");

echo "<br />";
//bool ctype_space ( string $text )字符是否包含空白
//除了空白字符，还包括缩进，垂直制表符，换行符，回车和换页字符。
$r = ctype_space(' '); e($r, "ctype_space(' ')");
$r = ctype_space("\n\r\t"); e($r, "ctype_space(\"\\n\\r\\t\")");

echo "<br />";
//bool ctype_xdigit ( string $text )
//检查 string 和 text 里面的字符是不是都是十六进制字符串。
$r = ctype_xdigit('FFF123'); e($r, "ctype_xdigit('FFF123')");
$r = ctype_xdigit('FFF123g'); e($r, "ctype_xdigit('FFF123g')");

echo "<br />";
//bool ctype_punct ( string $text )检测可打印的字符是不是不包含空白、数字和字母
//字符是不是都是标点符号
$r = ctype_punct(',.;!@#$%');  e($r, "ctype_punct(',.;!@#$%')");
$r = ctype_punct(',.;!@#$ %');  e($r, "ctype_punct(',.;!@#$ %')");


$num = 100000;
$t1 = 0; $t2 = 0;
$r = 'fddf23jdfjdkfeieeeeeeeeeeeefkdfiee9388888888920547jksdpowkvcccccccckjsds'
    . 'i4ddf23jdfjdkfeieeeeeeeeeeeefkdfiee9388888888920547jksdpowkvcccccccckjsdsi4';

$t1 = microtime(true);
for($j = 0; $j < $num; $j++){
    ctype_alnum("$r");
}
$t2 = microtime(true);
$d = bcsub($t2, $t1, 4);
echo 'ctype_alnum '.$d."<br />";
$t1 = 0; $t2 = 0;

$t1 = microtime(true);
for($j = 0; $j < $num; $j++){
    is_numeric("$r");
}
$t2 = microtime(true);
$d = bcsub($t2, $t1, 4);
echo 'is_numeric '.$d."<br />";
$t1 = 0; $t2 = 0;