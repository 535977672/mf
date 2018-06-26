<?php

/*
 * 访问双引号内的数组 echo "Hello {$foo['bar']}!";
 * array_change_key_case — 将数组中的所有键名修改为全大写或小写
 * array_chunk — 将一个数组分割成多个
 * array_column — 返回数组中指定的一列
 * array_combine — 创建一个数组，用一个数组的值作为其键名，另一个数组的值作为其值
 * array_count_values — 统计数组中所有的值
 * array_diff_assoc — 带索引检查计算数组的差集
 * array_diff_key — 使用键名比较计算数组的差集
 * array_diff_uassoc — 用用户提供的回调函数做索引检查来计算数组的差集
 * array_diff_ukey — 用回调函数对键名比较计算数组的差集
 * array_diff — 计算数组的差集
 * array_fill_keys — 使用指定的键和值填充数组
 * array_fill — 用给定的值填充数组
 * array_filter — 用回调函数过滤数组中的单元
 * array_flip — 交换数组中的键和值
 * array_intersect_assoc — 带索引检查计算数组的交集
 * array_intersect_key — 使用键名比较计算数组的交集
 * array_intersect_uassoc — 带索引检查计算数组的交集，用回调函数比较索引
 * array_intersect_ukey — 用回调函数比较键名来计算数组的交集
 * array_intersect — 计算数组的交集
 * array_key_exists — 检查数组里是否有指定的键名或索引
 * array_keys — 返回数组中部分的或所有的键名
 * array_map — 为数组的每个元素应用回调函数
 * array_merge_recursive — 递归地合并一个或多个数组
 * array_merge — 合并一个或多个数组
 * array_multisort — 对多个数组或多维数组进行排序
 * array_pad — 以指定长度将一个值填充进数组
 * array_pop — 弹出数组最后一个单元（出栈）
 * array_product — 计算数组中所有值的乘积
 * array_push — 将一个或多个单元压入数组的末尾（入栈）
 * array_rand — 从数组中随机取出一个或多个单元
 * array_reduce — 用回调函数迭代地将数组简化为单一的值
 * array_replace_recursive — 使用传递的数组递归替换第一个数组的元素
 * array_replace — 使用传递的数组替换第一个数组的元素
 * array_reverse — 返回单元顺序相反的数组
 * array_search — 在数组中搜索给定的值，如果成功则返回首个相应的键名
 * array_shift — 将数组开头的单元移出数组
 * array_slice — 从数组中取出一段
 * array_splice — 去掉数组中的某一部分并用其它值取代
 * array_sum — 对数组中所有值求和
 * array_udiff_assoc — 带索引检查计算数组的差集，用回调函数比较数据
 * array_udiff_uassoc — 带索引检查计算数组的差集，用回调函数比较数据和索引
 * array_udiff — 用回调函数比较数据来计算数组的差集
 * array_uintersect_assoc — 带索引检查计算数组的交集，用回调函数比较数据
 * array_uintersect_uassoc — 带索引检查计算数组的交集，用单独的回调函数比较数据和索引
 * array_uintersect — 计算数组的交集，用回调函数比较数据
 * array_unique — 移除数组中重复的值
 * array_unshift — 在数组开头插入一个或多个单元
 * array_values — 返回数组中所有的值
 * array_walk_recursive — 对数组中的每个成员递归地应用用户函数
 * array_walk — 使用用户自定义函数对数组中的每个元素做回调处理
 * array — 新建一个数组
 * arsort — 对数组进行逆向排序并保持索引关系
 * asort — 对数组进行排序并保持索引关系
 * compact — 建立一个数组，包括变量名和它们的值
 * count — 计算数组中的单元数目，或对象中的属性个数
 * current — 返回数组中的当前单元
 * each — 返回数组中当前的键／值对并将数组指针向前移动一步
 * end — 将数组的内部指针指向最后一个单元
 * extract — 从数组中将变量导入到当前的符号表
 * in_array — 检查数组中是否存在某个值
 * key_exists — 别名 array_key_exists
 * key — 从关联数组中取得键名
 * krsort — 对数组按照键名逆向排序
 * ksort — 对数组按照键名排序
 * list — 把数组中的值赋给一组变量
 * natcasesort — 用“自然排序”算法对数组进行不区分大小写字母的排序
 * natsort — 用“自然排序”算法对数组排序
 * next — 将数组中的内部指针向前移动一位
 * pos — current 的别名
 * prev — 将数组的内部指针倒回一位
 * range — 根据范围创建数组，包含指定的元素
 * reset — 将数组的内部指针指向第一个单元
 * rsort — 对数组逆向排序
 * shuffle — 打乱数组
 * sizeof — count 的别名
 * sort — 对数组排序
 * uasort — 使用用户自定义的比较函数对数组中的值进行排序并保持索引关联
 * uksort — 使用用户自定义的比较函数对数组中的键名进行排序
 * usort — 使用用户自定义的比较函数对数组中的值进行排序
 */

/**
 * 输出
 * @param type $msg
 * @param type $flag
 */
function e(&$msg, $flag = 1){
    if($flag == 1){
        var_dump($msg);
    }else if($flag == 2){
        echo $msg;
    }
    unset($msg);
    //unset() 一个通过引用传递的变量，则只是局部变量被销毁，而在调用环境中的变量将保持调用 unset() 之前一样的值。
    //可使用 $GLOBALS 数组来实现：unset($GLOBALS['r']);
    unset($GLOBALS['r']);
}

/**
 * 用用户提供的回调函数做索引检查来计算数组的差集
 * 在第一个参数小于，等于或大于第二个参数时，该比较函数必须相应地返回一个小于，等于或大于 0 的整数。
 * @param type $a
 * @param type $b
 */
function diff_uassoc($a, $b){
    if($a === $b){
        return 0;
    }
    return ($a > $b)?1:-1;
}

/**
 * @param type $key1
 * @param type $key2
 */
function diff_ukey($key1, $key2){
    if($key1 == $key2){
        return 0;
    } elseif ($key1 > $key2) {
        return 1;
    }  else {
        return -1; 
    }
}

$a1 = [1,3,5,7,9,2,4,6,8,0,10];$a11 = [2,4,6,8,0,1,3,5,7,9,11];$a111 = [1,3,5,7,9,2,4,6,8,0,11];
$a2 = ['test1'=>'测试1','test2'=>'测试2','test3'=>'测试3','test4'=>'测试4','test5'=>'测试5'];
$a22 = ['test1'=>'测试1','test2'=>'测试2','test3'=>'测试3','test4'=>'测试4','test6'=>'测试6'];
$a3 = [$a2,$a1,$a2,$a1];$a33 = [$a2,$a2,$a2,$a2];
$a4 = [['id'=>1,'msg'=>'t1'],['id'=>2,'msg'=>'t2'],['id'=>3,'msg'=>'t3'],['id'=>4,'msg'=>'t4']];

//将数组中的所有键名修改为全大写或小写
$r = array_change_key_case($a2, CASE_UPPER); e($r);
//array_chunk — 将一个数组分割成多个
$r = array_chunk($a1, 3, true); e($r);
/************array_column 返回多维数组中指定的一列***************************************************/
$r = array_column($a4, 'msg', 'id'); e($r);
//创建一个数组，用一个数组的值作为其键名，另一个数组的值作为其值
$r = array_combine($a1, $a11); e($r);
//统计数组中所有的值
$r = array_count_values($a1); e($r);

$r = "数组差集";e($r);
//数组差集
$r = array_diff_assoc($a1, $a111); e($r);
$r = array_diff_key($a1, $a111); e($r);
$r = array_diff_uassoc($a1, $a111, 'diff_uassoc'); e($r);
$r = array_diff_ukey($a1, $a111, 'diff_ukey'); e($r);
$r = array_diff($a1, $a111); e($r);//$a1 的键名或键值在 $a111的键名或键值存在 的都不返回

$r = "数组交集";e($r);
//数组交集
$r = array_intersect_assoc($a1, $a111); e($r);
$r = array_intersect_key($a1, $a111); e($r);
$r = array_intersect_uassoc($a1, $a111, 'diff_uassoc'); e($r);
$r = array_intersect_ukey($a1, $a111, 'diff_ukey'); e($r);
$r = array_intersect($a1, $a111); e($r);//$a1 的键名或键值在 $a111的键名或键值存在 的都返回

//填充
$r = array_fill_keys($a2, '填充键值'); e($r);
$r = array_fill(2, 3, '填充值'); e($r);
//补填
$r = array_pad($a1,15,'123'); e($r);
$r = array_pad($a1,-15,'123'); e($r);

//过滤
$r = array_filter($a1); e($r);
$r = array_filter($a1, function($k){ return $k > 8; }, ARRAY_FILTER_USE_KEY); e($r);
$r = array_filter($a1, function($v, $k){ return $k > 8 || $v > 8; }, ARRAY_FILTER_USE_BOTH); e($r);

//键值交换
$r = array_flip($a1); e($r);

//键名 键值 返回全部键名
$r = array_key_exists(5, $a1); e($r);
$r = array_keys($a1);  e($r);
$r = array_keys($a1, 5, true);  e($r);
$r = array_keys($a1, '5', true);  e($r);

//搜索值 返回第一个键名  可结合array_keys()返回全部键名
$r = array_search(5, $a1); e($r);
$r = array_search(5, $a1, true); e($r);//严格比较
$r = array_search('5', $a1, true); e($r);//false

$r = array_values($a1);  e($r);

//map遍历
$callback1 = function($n){
    return $n*2;
};
$callback2 = function($n,$m){
    return $n+$m;
};
$r = array_map($callback1, $a1); e($r);
$r = array_map($callback2, $a1, $a11); e($r);

//递归合并 如果输入的数组中有相同的字符串键名，则这些值会被合并到一个数组中去，
//这将递归下去，因此如果一个值本身是一个数组，本函数将按照相应的条目把它合并为另一个数组。
//然而，如果数组具有相同的数组键名，后一个值将不会覆盖原来的值，而是附加到后面。
$r = array_merge_recursive($a2, $a22); e($r);
//非递归合并 如果输入的数组中有相同的字符串键名，则该键名后面的值将覆盖前一个值。
//然而，如果数组包含数字键名，后面的值将不会覆盖原来的值，而是附加到后面。
$r = array_merge($a2, $a22); e($r);

//数组尾 栈
echo '栈';
$r = array_pop($a4); e($r);
array_push($a4, $r);
//数组头 移除 添加
$r = array_shift($a4); e($r); 
//注意单元是作为整体被插入的，因此传入单元将保持同样的顺序。所有的数值键名将修改为从零开始重新计数，所有的文字键名保持不变。
$r = array_unshift($a4, $r); e($r); 

//计算
$r = array_product($a1); e($r);//乘积
$r = array_sum($a1); e($r);//求和
//将数组简化为单一的值
$callback3 = function($sum,$v){
    $sum += $v;
    return $sum;
};
$r = array_reduce($a1, $callback3); e($r);

//取随机键名
$r = array_rand($a1); e($r);//$r = array_rand($a1,1);
$r = array_rand($a1,3); e($r);

//替换
$r = array_replace_recursive($a3, $a33); e($r);//递归的，可替换多维数组
$r = array_replace($a3, $a33); e($r);//不管数据类型，只替换第一个数组的元素

//数组顺序反向
$r = array_reverse($a1); e($r);
$r = array_reverse($a1, true); e($r);//数字键名保留

 
//提取片段 array array_slice ( array $array , int $offset [, int $length = NULL [, bool $preserve_keys = false ]] )
//offset 如果 offset 非负，则序列将从 array 中的此偏移量开始。如果 offset 为负，则序列将从 array 中距离末端这么远的地方开始。
//length 如果给出了 length 并且为正，则序列中将具有这么多的单元。如果给出了 length 并且为负，则序列将终止在距离数组末端这么远的地方。如果省略，则序列将从 offset 开始一直到 array 的末端。
//preserve_keys 注意 array_slice() 默认会重新排序并重置数组的数字索引。你可以通过将 preserve_keys 设为 TRUE 来改变此行为。
$r = array_slice($a1, 5, 2, true);  e($r);

//array_splice — 去掉数组中的某一部分并用其它值取代  返回移除单元
$r = array_splice($a1, 5, 2, ['替换', '替换']);  e($r);e($a1);

//去重 array array_unique ( array $array [, int $sort_flags = SORT_STRING ] )
//SORT_REGULAR - 按照通常方法比较（不修改类型）按照字母顺序
//SORT_NUMERIC - 按照数字形式比较
//SORT_STRING - 按照字符串形式比较
//SORT_LOCALE_STRING - 根据当前的本地化设置，按照字符串比较。
$r = array_unique($a1, SORT_STRING);  e($r);
$r = array_unique($a1, SORT_NUMERIC);  e($r);

//bool array_walk_recursive — 对数组中的每个成员递归地应用用户函数
//任何其值为 array 的键都不会被传递到回调函数中去。
$r = array_walk_recursive($a1, function($v,$k){echo "$k=>$v".PHP_EOL;});   e($r);
$r = array_walk($a1, function($v,$k,$userdata){echo "$k=>$v.$userdata".PHP_EOL;}, '数据');   e($r);

//排序 13种
//SORT_REGULAR - 正常比较单元（不改变类型）按照字母顺序
//SORT_NUMERIC - 单元被作为数字来比较
//SORT_STRING - 单元被作为字符串来比较
//SORT_LOCALE_STRING - 根据当前的区域（locale）设置来把单元当作字符串比较，可以用 setlocale() 来改变。
//SORT_NATURAL - 和 natsort() 类似对每个单元以“自然的顺序”对字符串进行排序。 PHP 5.4.0 中新增的。
//SORT_FLAG_CASE - 能够与 SORT_STRING 或 SORT_NATURAL 合并（OR 位运算），不区分大小写排序字符串。
$a55 = $a5 = [1,6,9,'sd','是',3,'烦人','fd',32,0];

//bool sort ( array &$array [, int $sort_flags = SORT_REGULAR ] )
$r = sort($a5); e($r);e($a5);$a5 = $a55;
$r = rsort($a5); e($r);e($a5);$a5 = $a55;//逆向
$r = asort($a5); e($r);e($a5);;$a5 = $a55;//带索引
$r = arsort($a5); e($r);e($a5);;$a5 = $a55;

$r = ksort($a5); e($r);e($a5);$a5 = $a55;
$r = krsort($a5); e($r);e($a5);$a5 = $a55;//逆向

//usort — 使用用户自定义的比较函数对数组中的值进行排序
function callables($a, $b){
    if($a === $b){
        return 0;
    }
    return ($a > $b)?1:-1;
}
$r = usort($a5, 'callables'); e($r);e($a5);$a5 = $a55;
$r = uasort($a5, 'callables'); e($r);e($a5);$a5 = $a55;
$r = uksort($a5, 'callables'); e($r);e($a5);$a5 = $a55;

//随机打乱
$r = shuffle($a5); e($r);e($a5);$a5 = $a55;
//natsort — 用“自然排序”算法对数组排序
$r = natsort($a5); e($r);e($a5);$a5 = $a55;
$r = natcasesort($a5); e($r);e($a5);$a5 = $a55;//不区分大小写字母的排序

//array_multisort — 对多个数组或多维数组进行排序







/*********************compact — 建立一个数组，包括变量名和它们的值***************************************/
$q1 = 'post数据1'; $q2 = 'get数据1';$q3 = 'post数据2'; $q4 = 'get数据2';
$r = compact('q1','q2','q3','q4'); e($r);
//extract - 从数组中将变量导入到当前的符号表  信任数据才用  字符索引-和list()区别,数组索引

//count() - 计算数组中的单元数目，或对象中的属性个数
$r = count($a1); e($r);

/****************数组指针*******************************************************************************/
//current==pos next prev end key
$r = reset($a1); e($r);
$r = current($a1); e($r);//1.超出末端-》false  2.值false-》false
$r = next($a1); e($r);//返回的是下一个数组单元的值 内部指针向前移动一位
$r = prev($a1); e($r);
$r = end($a1); e($r);
$r = reset($a1); e($r);//内部指针倒回到第一个单元并返回第一个数组单元的值。
$r = current($a1); e($r);
$r = key($a1); e($r);//键名

//each 返回数组中当前的键／值对并将数组指针向前移动一步
//在执行 each() 之后，数组指针将停留在数组中的下一个单元或者当碰到数组结尾时停留在最后一个单元。
//如果要再用 each 遍历数组，必须使用 reset()。
//返回 array 数组中当前指针位置的键／值对并向前移动数组指针。键值对被返回为四个单元的数组，
//键名为0，1，key和 value。单元 0 和 key 包含有数组单元的键名，1 和 value 包含有数据。
//如果内部指针越过了数组的末端，则 each() 返回 FALSE。
$r = each($a2); e($r);//array(4) {[1]=>string(7) "测试1" ["value"]=>string(7) "测试1" [0]=> string(5) "test1" ["key"]=> string(5) "test1"}
$r = each($a2); e($r);//array(4) {[1]=>string(7) "测试2" ["value"]=>string(7) "测试2" [0]=> string(5) "test2" ["key"]=> string(5) "test2"}
reset($a2);

//list  把数组中的值赋给一组变量  像 array() 一样，这不是真正的函数，而是语言结构。
//list() 仅能用于------数字索引------的数组，并假定数字索引从 0 开始。和元素添加顺序无关
$t1 = ['1'=>1,'5'=>['0'=>6, '1'=>8]];
$r = list(,$z1,,,,list($z2,$z3)) = $t1;  e($z1);e($z2);e($z3); //返回指定的数组$t1

//each 结合 list 遍历数组 / foreach
$t2 = ['1refd'=>1,'sdfd'=>6];
reset($t2);
while(list(,$v) = each($t2)){
    echo $v.PHP_EOL;
}
//当 foreach 开始执行时，数组内部的指针会自动指向第一个单元。这意味着不需要在 foreach 循环之前调用 reset()。
foreach ($t2 as $v) {
    echo $v.PHP_EOL;
}
//用 list() 给嵌套的数组解包
$t3 = ['0'=>['0'=>5,'1'=>7],'1'=>['0'=>8,'1'=>9]];
//php 5.6.15 不兼容
//foreach ($t3 as list($z1,$z2)) {
//    echo $z1.','.$z2.PHP_EOL;
//}



//in_array — 检查数组中是否存在某个值
$r = in_array(5, $a1); e($r);
//array range ( mixed $start , mixed $end [, number $step = 1 ] ) — 根据范围创建数组，包含指定的元素
$r = range(0, 10); e($r);
$r = range(0, 100, 10); e($r);
//字符序列值仅限单个字符。 如果长度大于1，仅仅使用第一个字符。
$r = range('a', 'g', 2); e($r);

