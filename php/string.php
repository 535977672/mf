<?php
/**
 * 1.
 * 当选择对字符 0，a，b，f，n，r，t 和 v 进行转义时需要小心，
 * 它们将被转换成 \0，\a，\b，\f，\n，\r，\t 和 \v。
 * 在 PHP 中，只有 \0（NULL），\r（回车符），\n（换行符）和 \t（制表符）是预定义的转义序列， 
 * 而在 C 语言中，上述的所有转换后的字符都是预定义的转义序列。
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

$s1 = '135479246840';
$s2 = 'acegikmo';
$s3 = '1a2b3c4d5e6f7h8i9j';
$s4 = '测试字符串';
$s5 = '测 试~`!@#$%^&*():";?/-_+=|{}[],.<>\\\'0abfntrv';
e($s1, 's1');
e($s2, 's2');
e($s3, 's3');
e($s4, 's4');
e($s5, 's5');

$s7 = "abc \"ddd\" efg 'hhh' ijk <a>LLL</a>";e($s7, 's7');
$s8 = " abc DFG Hdf ghFGg! ";e($s8, 's8');

$s9 = "first=value1&two=测试&three[]=aaaa&three[]=bbbb"; e($s9, 's9');

echo "<br />";
//addcslashes — 以 C 语言风格使用反斜线转义字符串中的字符
//stripcslashes — 反引用一个使用 addcslashes() 转义的字符串
$r = addcslashes($s5, 'a..z'); e($r, 'addcslashes($s5, \'a..z\')');
$r = stripcslashes(addcslashes($s5, 'a..z')); e($r, 'stripcslashes(addcslashes($s5, \'a..z\'))');

/**
 * string addslashes ( string $str ) 使用反斜线引用字符串
 * 返回字符串，该字符串为了数据库查询语句等的需要在某些字符前加上了反斜线。
 * 这些字符是单引号（'）、双引号（"）、反斜线（\）与 NUL（NULL 字符）。
 * 
 * 强烈建议使用 DBMS 指定的转义函数 
 * MySQL 是 mysqli_real_escape_string()
 * PostgreSQL 是 pg_escape_string()
 * 如果你使用的 DBMS 没有一个转义函数，并且使用 \ 来转义特殊字符，你可以使用这个函数。
 * 仅仅是为了获取插入数据库的数据，额外的 \ 并不会插入。 
 * 当 PHP 指令 magic_quotes_sybase 被设置成 on 时，意味着插入 ' 时将使用 ' 进行转义。
 * 
 * PHP 5.4 之前 PHP 指令 magic_quotes_gpc 默认是 on， 
 * 实际上所有的 GET、POST 和 COOKIE 数据都用被 addslashes() 了。 
 * 不要对已经被 magic_quotes_gpc 转义过的字符串使用 addslashes()，因为这样会导致双层转义。
 * 遇到这种情况时可以使用函数 get_magic_quotes_gpc() 进行检测。
 * 
 * bool get_magic_quotes_gpc ( void ) — 获取当前 magic_quotes_gpc 的配置选项设置
 * 如果 magic_quotes_gpc 为关闭时返回 0，否则返回 1。在 PHP 5.4.O 起将始终返回 FALSE。
 */
$r = addslashes($s5); e($r, 'addcslashes($s5)');
//$r = mysql_real_escape_string($s5); e($r, 'mysql_real_escape_string($s5)');//要连接数据库
//if(get_magic_quotes_gpc()){
//    $r = stripslashes($s5); e($r, 'get_magic_quotes_gpc() = on; stripslashes($s5)');
//}else{
//    e($s5); e('', 'get_magic_quotes_gpc() = off; e($s5)');
//}

//string quotemeta ( string $str ) 转义元字符集
//特殊字符前加 反斜线(\) 转义后的字符串 . \ + * ? [ ^ ] ( $ )
$r = quotemeta($s5); e($r, 'quotemeta($s5)');



echo "<br />";
//bin2hex — 函数把包含数据的二进制字符串转换为十六进制值
$r = bin2hex($s1); e($r, 'bin2hex($s1)');
$r = hex2bin(bin2hex($s1)); e($r, 'hex2bin(bin2hex($s1))');//转换十六进制字符串为二进制字符串。

//int ord ( string $string ) 返回字符串 string 第一个字符的 ASCII 码值。
//string chr ( int $ascii ) — 返回指定的字符
$r = chr( ord("dD") ); e($r, 'chr( ord("dD") )');

//string chunk_split ( string $body [, int $chunklen = 76 [, string $end = "\r\n" ]] )
//函数将字符串分割成小块非常有用。例如将 base64_encode() 的输出转换成符合 RFC 2045 语义的字符串。它会在每 chunklen 个字符后边插入 end。
$r = chunk_split($s1,3, ","); e($r, 'chunk_split($s1,2, ",")');

echo "<br />";
//string convert_cyr_string ( string $str , string $from , string $to )
//把字符串由一种字符集转换成另一种
//支持的类型有：
//k - koi8-r
//w - windows-1251
//i - iso8859-5
//a - x-cp866
//d - x-cp866
//m - x-mac-cyrillic
$r = convert_cyr_string("sdw!@#! æøå","w", "a");  e($r, 'convert_cyr_string("sdw!@#! æøå","w", "a")');

//convert_uuencode convert_uudecode  — 使用 uuencode 编码一个字符串
//uuencode 算法会将所有（含二进制）字符串转化为可输出的字符， 并且可以被安全的应用于网络传输。
//使用 uuencode 编码后的数据 将会比源数据大35%左右
$r = convert_uuencode($s1);  e($r, 'convert_uuencode($s1)');
$r = convert_uudecode("*,3,U-SDR-#8X,``` ` ");  e($r, 'convert_uudecode("*,3,U-SDR-#8X,``` ` ")');

//mixed count_chars ( string $string [, int $mode = 0 ] )
//统计 string 中每个字节值（0..255）出现的次数，使用多种模式返回结果。
//根据不同的 mode，count_chars() 返回下列不同的结果：
//0 - 以所有的每个字节值作为键名，出现次数作为值的数组。
//1 - 与 0 相同，但只列出出现次数大于零的字节值。
//2 - 与 0 相同，但只列出出现次数等于零的字节值。
//3 - 返回由所有使用了的字节值组成的字符串。
//4 - 返回由所有未使用的字节值组成的字符串。
$r1 = $r = count_chars($s1, 1);  e($r, 'count_chars($s1, 1)');
foreach ($r1 as $k=>$v){
    e($v, chr($k));
}
$r1 = $r = count_chars($s1, 3);  e($r, 'count_chars($s1, 3)');

echo "<br />";

/**
 * 加密
 */
//int crc32 ( string $str )— CRC的全称是循环冗余校验 计算一个字符串的 crc32 多项式
//生成 str 的 32 位循环冗余校验码多项式。这通常用于检查传输的数据是否完整。
//由于 PHP 的整数是带符号的，所以在 32 位系统上许多 crc32 校验码将返回负整数。 
//尽管在 64 位上所有 crc32() 的结果将都是正整数。
//因此你需要使用 sprintf() 或 printf() 的“%u”格式符来获取表示无符号 crc32 校验码的字符串。
$r = crc32($s1);   e($r, 'crc32($s1)');
//输出缓冲区
ob_start();
printf("%u\n", crc32($s2)); 
$string = ob_get_contents();
ob_flush();
flush();
e($string, 'printf("%u\n", crc32($s2))');//返回输出字符串的长度

//string crypt ( string $str [, string $salt ] ) — 单向字符串散列
//crypt() 返回一个基于标准 UNIX DES 算法或系统上其他可用的替代算法的散列字符串。
$r = crypt($s1);   e($r, 'crypt($s1)');
$r = crypt($s1, "dfjdf");   e($r, 'crypt($s1)');

echo "<br />";
/**
 * md5_file — 计算指定文件的 MD5 散列值
 * md5 — 计算字符串的 MD5 散列值
 */
$r = md5_file("./phpinfo.php"); e($r, 'md5_file("./phpinfo.php")');//32 字符的十六进制数字。
$r = md5_file("./phpinfo.php", true); e($r, 'md5_file("./phpinfo.php", true)');//16 位二进制格式返回
$r = md5($s1); e($r, 'md5($s1)');
$r = md5($s1, true); e($r, 'md5($s1, true)');

echo "<br />";
/**
 * sha1 — 计算字符串的 sha1 散列值
 */
$r = sha1_file("./phpinfo.php"); e($r, 'sha1_file("./phpinfo.php")');//40 字符长度的十六进制数字。
$r = sha1_file("./phpinfo.php", true); e($r, 'sha1_file("./phpinfo.php", true)');// 20 字符长度的原始格式返回。
$r = sha1($s1); e($r, 'sha1($s1)');
$r = sha1($s1, true); e($r, 'sha1($s1, true)');

echo "<br />";
//str_rot13 — 对字符串执行 ROT13 转换  只能是字母转换
//ROT13 编码简单地使用字母表中后面第 13 个字母替换当前字母，同时忽略非字母表中的字符。编码和解码都使用相同的函数，传递一个编码过的字符串作为参数，将得到原始字符串。
$r = str_rot13($s2); e($r, 'str_rot13($s2)');//只能是字母转换
$r = str_rot13(str_rot13($s2)); e($r, 'str_rot13(str_rot13($s2))');

echo "<br />";
/**
 * 输出
 */
e($r, 'echo(echo $s1,$s2,$s3)');
//void echo — 输出一个或多个字符串 
//echo 不是一个函数（它是一个语言结构）， 因此你不一定要使用小括号来指明参数，单引号，双引号都可以。
echo $s1,$s2,$s3;

//fprintf — 将格式化后的字符串写入到流
//printf — 输出格式化字符串
//sprintf — Return a formatted string
//sscanf — 根据指定格式解析输入的字符

echo "<br />"; e($r, 'print "print()"');
//print — 输出字符串
//print 实际上不是函数（而是语言结构），所以可以不用圆括号包围参数列表。
//和 echo 的唯一区别： print 仅支持一个参数。总是返回 1。
print "print()";


echo "<br />";echo "<br />";

/**
 * explode — 使用一个字符串分割另一个字符串
 * implode — 将一个一维数组的值转化为字符串
 */
$r = explode("4", $s1);   e($r, 'explode("4", $s1)');
$r = explode("4", $s1, -1);   e($r, 'explode("4", $s1, -1)');

$r = implode("4", explode("4", $s1));   e($r, 'implode("4", explode("4", $s1))');

echo "<br />";

/**
 * htmlentities — 将字符转换为 HTML 转义字符
 * 本函数各方面都和 htmlspecialchars() 一样， 除了 htmlentities() 会转换所有具有 HTML 实体的字符。
 * 如果要解码（反向操作），可以使用 html_entity_decode()。
 * 
 * htmlspecialchars — 将特殊字符转换为 HTML 实体
 * & ' " < >
 * 
 * strip_tags — 去除空字符、HTML 和 PHP 标记后的结果
 */
$r1 = $r = htmlentities($s7); e($r, 'htmlentities($s7)');
$r2 = $r = htmlentities($s7, ENT_QUOTES); e($r, 'htmlentities($s7, ENT_QUOTES)');

$r = html_entity_decode($r1); e($r, 'html_entity_decode(htmlentities($s7))');
$r = html_entity_decode($r2, ENT_QUOTES); e($r, 'html_entity_decode(htmlentities($s7, ENT_QUOTES), ENT_QUOTES)');

$r1 = $r = htmlspecialchars($s7); e($r, 'htmlspecialchars($s7)');
$r2 = $r = htmlspecialchars($s7, ENT_QUOTES); e($r, 'htmlspecialchars($s7, ENT_QUOTES)');

$r = htmlspecialchars_decode($r1); e($r, 'htmlspecialchars_decode(htmlspecialchars($s7))');
$r = htmlspecialchars_decode($r2, ENT_QUOTES); e($r, 'htmlspecialchars_decode(htmlspecialchars($s7, ENT_QUOTES), ENT_QUOTES)');

$r = strip_tags($s7); e($r, 'strip_tags($s7)');
$r = strip_tags($s7, '<a>'); e($r, 'strip_tags($s7, \'<a>\')');


echo "<br />";e($s8, 's8');
//大小写转换
$r = lcfirst($s8); e($r, 'lcfirst($s8)');
$r = ucfirst($s8); e($r, 'ucfirst($s8)');
$r = strtolower($s8); e($r, 'strtolower($s8)');
$r = strtoupper($s8); e($r, 'strtoupper($s8)');
$r = ucwords($s8); e($r, 'ucwords($s8)');

echo "<br />";
//int levenshtein ( string $str1 , string $str2 ) — 计算两个字符串之间的编辑距离
//编辑距离，是指两个字串之间，通过替换、插入、删除等操作将字符串str1转换成str2所需要操作的最少字符数量。
$r = levenshtein($s1, $s2); e($r, 'levenshtein($s1, $s2)');
$r = levenshtein("ereeoor", "error"); e($r, 'levenshtein("errroor", "error")');
//metaphone() 计算字符串的 metaphone 键,函数为发音相似的单词创建相同的键。metaphone 键长度可变
//metaphone 键代表字符串的英语发音。metaphone() 函数可用于拼写检查程序。
$r = metaphone("study"); e($r, 'metaphone("study")');
$r = metaphone("studies"); e($r, 'metaphone("studies")');
$r = metaphone("study",2); e($r, 'metaphone("study",2)');
//soundex() 函数计算字符串的 soundex 键。soundex 键是 4 字符长的字母数字字符串，表示单词的英文发音。
$r = soundex("study"); e($r, 'soundex("study")');
$r = soundex("studies"); e($r, 'soundex("studies")');
//int similar_text ( string $first , string $second [, float &$percent ] ) — 计算两个字符串的相似度
//返回在两个字符串中匹配字符的数目。
$r = similar_text($s1, $s3, $p); e($r, 'similar_text($s1, $s3, $p)');e($p, '相似度');

echo "<br />";
//localeconv — Get numeric formatting information
//setlocale — 设置地区信息
//$r = localeconv(); e($r, 'localeconv()');

echo "<br />";
/**
 * 去除空白字符  \t\n\r\0\x0B
 *  " " (ASCII 32 (0x20))，普通空白字符。
 *  "\t" (ASCII 9 (0x09))， 制表符.
 *  "\n" (ASCII 10 (0x0A))，换行符。
 *  "\r" (ASCII 13 (0x0D))，回车符。
 *  "\0" (ASCII 0 (0x00))， NUL空字节符。
 *  "\x0B" (ASCII 11 (0x0B))，垂直制表符。
 */
$r = ltrim($s8); e($r, 'ltrim($s8)');
$r = rtrim($s8); e($r, 'rtrim($s8)');
$r = trim($s8, '! '); e($r, 'trim($s8, "! ")');

echo "<br />";
//money_format — 将数字格式化成货币字符串
//具有 strfmon 的系统才有 money_format() 函数。 例如 Windows 不具备，所以 Windows 系统上 money_format() 未定义。
//locale 设置中， LC_MONETARY 会影响此函数的行为。 在使用函数前，首先要用 setlocale() 来设置合适的区域设置（locale）。
//setlocale(LC_MONETARY, 'en_US');
//$r = money_format('%i', 123.21); e($r, 'money_format(\'%i\', 123.21)');

/**
 * number_format — 以千位分隔符方式格式化一个数字
 */
$r = number_format(54212123.61); e($r, 'number_format(54212123.61)');
$r = number_format(54212123.61, 2); e($r, 'number_format(54212123.61, 2)');
$r = number_format(54212123.61, 2, "。" , "~"); e($r, 'number_format(54212123.61, 2, "。" , "~")');

echo "<br />";
/**
 * void parse_str ( string $str [, array &$arr ] )
 * 将字符串解析成多个变量
 * 如果 str 是 URL 传递入的查询字符串（query string），则将它解析为变量并设置到当前作用域。
 */
$r = parse_str($s9); e($r, 'parse_str($s9)');
e($first, '$first');e($two, '$two');e($three, '$three');
parse_str($s9, $re); e($re, 'parse_str($s9, $re)');

echo "<br />";
/**
 * 填充
 * string str_pad ( string $input , int $pad_length [, string $pad_string = " " [, int $pad_type = STR_PAD_RIGHT ]] )
 */
$r = str_pad($s1, 20, '0', STR_PAD_LEFT); e($r, 'str_pad($s1, 20, \'0\', STR_PAD_LEFT)');

//str_repeat — 重复一个字符串
$r = str_repeat($s1, 3); e($r, 'str_repeat($s1, 1)');

//mixed str_replace/str_ireplace ( mixed $search , mixed $replace , mixed $subject [, int &$count ] )
$r = str_replace(4, '', $s1, $count); e($r, 'str_replace(4, \'\', $s1, $count)'); e($count, '$count');

//str_shuffle — 随机打乱一个字符串
$r = str_shuffle($s1); e($r, 'str_shuffle($s1)');

//str_split — 将字符串转换为数组
$r = str_split($s1, 3); e($r, 'str_split($s1, 3)');

echo "<br />";
/**
 * 比较
 * strcasecmp — 二进制安全比较字符串（不区分大小写）
 * strcmp — 二进制安全字符串比较
 * 
 * strcoll — 基于区域设置的字符串比较
 * strcoll() 使用当前区域设置进行比较。如果当前区域为 C 或 POSIX，该函数等同于 strcmp()。
 * 
 * strcspn — 获取不匹配遮罩的起始子字符串的长度
 * 
 * substr — 返回字符串的子串
 * 
 * substr_replace — 替换字符串的子串
 * substr_replace() 在字符串 string 的副本中将由 start 和可选的 length 参数限定的子字符串使用 replacement 进行替换。
 * 
 * substr_count — 计算字串出现的次数
 * 
 * substr_compare — 二进制安全比较字符串（从偏移位置比较指定长度）
 * int substr_compare ( string $main_str , string $str , int $offset [, int $length [, bool $case_insensitivity = false ]] )
 */
$r = strcasecmp($s1, $s3); e($r, 'strcasecmp($s1, $s3)');
$r = strcmp($s1, $s3); e($r, 'strcmp($s1, $s3)');
$r = strcoll($s1, $s3); e($r, 'strcoll($s1, $s3)');

$r = strcspn($s3, $s2); e($r, 'strcspn($s3, $s2)');

$r = substr($s3, 1, 5); e($r, 'substr($s3, 1, 5)');
$r = substr_compare($s3, $s2, 1); e($r, 'substr_compare($s3, $s2, 1)');
$r = substr_replace($s3, $s2, 6, 3); e($r, 'substr_replace($s3, $s2, 6, 3)');
$r = substr_count($s1, "4"); e($r, 'substr_count($s1, "4")');

echo "<br />";
/**
 * 查找
 * mixed strpos/stripos ( string $haystack , string $needle [, int $offset = 0 ] )
 * strpos — 查找字符串首次出现的位置
 * 
 * string strstr/stristr ( string $haystack , mixed $needle [, bool $before_needle = false ] )
 * 返回 haystack 字符串从 needle 第一次出现的位置开始到 haystack 结尾的字符串。
 * 若为 TRUE，strstr() 将返回 needle 在 haystack 中的位置之前的部分。
 */
$r = stripos($s1, '4'); e($r, 'stripos($s1, \'4\')');

$r = stristr($s1, '4'); e($r, 'stristr($s1, \'4\')');
$r = stristr($s1, '4', true); e($r, 'stristr($s1, \'4\', true)');

//strlen — 获取字符串长度
$r = strlen($s1); e($r, 'strlen($s1)');

//strpbrk — 在字符串中查找一组字符的任何一个字符
$r = strpbrk($s1, "4"); e($r, 'strpbrk($s1, "4")');

//strrev — 反转字符串
$r = strrev($s1); e($r, 'strrev($s1)');























