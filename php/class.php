<?php

/*
 * 变量与类型相关扩展
 * 类/对象 — 类/对象的信息
 * 这些函数允许你获得类和对象实例的相关信息。 
 * 你可以获取对象所属的类名，也可以是它的成员属性和方法。 
 * 通过使用这些函数，你不仅可以找到对象和类的关系，也可以是它们的继承关系（例如，对象类继承自哪个类）。
 * __autoload — 尝试加载未定义的类  --PHP 7.2.0弃用
 * call_user_method_array — 以参数列表的数组，调用用户方法  --PHP 4.1.0弃用,PHP 7.0.0移除。call_user_func_array
 * call_user_method — 对特定对象调用用户方法  --PHP 4.1.0弃用,PHP 7.0.0移除。call_user_func
 * class_alias — 为一个类创建别名
 * class_exists — 检查类是否已定义
 * get_called_class — 后期静态绑定（"Late Static Binding"）类的名称
 * get_class_methods — 返回由类的方法名组成的数组
 * get_class_vars — 返回由类的默认属性组成的数组
 * get_class — 返回对象的类名
 * get_declared_classes — 返回由已定义类的名字所组成的数组
 * get_declared_interfaces — 返回一个数组包含所有已声明的接口
 * get_declared_traits — 返回所有已定义的 traits 的数组
 * get_object_vars — 返回由对象属性组成的关联数组
 * get_parent_class — 返回对象或类的父类名
 * interface_exists — 检查接口是否已被定义
 * is_a — 如果对象属于该类或该类是此对象的父类则返回 TRUE
 * is_subclass_of — 如果此对象是该类的子类，则返回 TRUE
 * method_exists — 检查类的方法是否存在
 * property_exists — 检查对象或类是否具有该属性
 * trait_exists — 检查指定的 trait 是否存在
 */
class class3 {
    public $r = 12;
    private $t;
        
    function __construct($r = '') {
        $this->r = $r;
    }
    
    public function e($msg = ''){
        if($msg) echo "测试3 ： $msg<br />";
        else echo "测试3 ： $this->r<br />";
    }
    
    static public function test1(){
        var_dump( 'test1 ：get_called_class() = ' . get_called_class() );echo "<br />";
    }
    
    public function test2(){
        var_dump( 'test2 ：get_called_class() = ' . get_called_class() );echo "<br />";
    }
}

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


//void __autoload ( string $class ) 尝试加载未定义的类 
//你可以通过定义这个函数来启用类的自动加载。 PHP 7.2.0弃用
function __autoload($classname){
    $filepath = './class/'.$classname.'.php';
    include_once ($filepath);
}

//bool class_alias ( string $original , string $alias [, bool $autoload = TRUE ] )
// 为一个类创建别名  如果原始类没有加载，是否使用自动加载（autoload）。是否默认调用 __autoload。
$r = class_alias('class3', 'class3_1', true); e($r, "class_alias('class3', 'class3_1', true)");
new class3_1('new class3_1()');

//bool class_exists ( string $class_name [, bool $autoload = true ] )
//检查指定的类是否已定义。
$r = class_exists('class3'); e($r, "class_exists('class3')");
$r = class_exists('class1',false); e($r, "class_exists('class1',false)");
$r = class_exists('class1'); e($r, "class_exists('class1')");
new class1('new class1()');

//string get_called_class ( void )后期静态绑定（"Late Static Binding"）类的名称
//返回类的名称，如果不是在类中调用则返回 FALSE。
class3::test1();
$r = new class3('e');$r->test2();


//array get_class_methods ( mixed $class_name ) 返回由类的方法名组成的数组
$r = get_class_methods('class3'); e($r, "get_class_methods('class3')");
$r = get_class_methods(new class3('e')); e($r, "get_class_methods(new class3())");

//array get_class_vars ( string $class_name )返回由类的默认公有属性组成的关联数组。
//string get_class ([ object $object = NULL ] ) 对象实例 object 所属类的名字。
$r = get_class_vars('class3'); e($r, "get_class_vars('class3')");
$r = get_class_vars(get_class(new class3('e'))); e($r, "get_class_vars(get_class(new class3('e')))");


//array get_object_vars ( object $obj )
$r = get_object_vars(new class3('e')); e($r, "get_object_vars(new class3())");

//string get_parent_class ([ mixed $obj ] ) — 返回对象或类的父类名

//bool interface_exists ( string $interface_name [, bool $autoload = true ] )检查接口是否已被定义

//bool is_a ( object $object , string $class_name [, bool $allow_string = FALSE ] )
//如果对象属于该类或该类是此对象的父类则返回 TRUE
$o = new class3('e');
$r = is_a(new class3('e'), 'class3'); e($r, 'is_a(new class3(\'e\'), \'class3\')');
if(new class3('e') instanceof class3) 
    e(new class3('e') instanceof class3, 'new class3(\'e\') instanceof class3');

//bool is_subclass_of ( object $object , string $class_name ) 如果此对象是该类的子类，则返回 TRUE

//bool method_exists ( mixed $object , string $method_name )
$r = method_exists(new class3('e'), 'test2'); e($r, "method_exists(new class3('e'), 'test2')");

//bool property_exists ( mixed $class , string $property )检查对象或类是否具有该属性
$r = property_exists(new class3(), 'r'); e($r, "method_exists(new class3(), 'r')");
$r = property_exists(new class3(), 't'); e($r, "method_exists(new class3(), 't')");

//array get_declared_classes ( void )返回由当前脚本中已定义类的名字组成的数组。
//$r = get_declared_classes(); e($r, "get_declared_classes()");

//array get_declared_interfaces ( void ) 返回一个数组包含所有已声明的接口
//$r = get_declared_interfaces(); e($r, "get_declared_interfaces()");

/**
 * Trait 是为类似 PHP 的单继承语言而准备的一种代码复用机制。
 * Trait 为了减少单继承语言的限制，使开发人员能够自由地在不同层次结构内独立的类中复用 method。
 * Trait 和 Class 组合的语义定义了一种减少复杂性的方式，避免传统多继承和 Mixin 类相关典型问题。
 * 
 * 从基类继承的成员会被 trait 插入的成员所覆盖。优先顺序是来自当前类的成员覆盖了 trait 的方法，而 trait 则覆盖了被继承的方法。
 * 通过逗号分隔，在 use 声明列出多个 trait，可以都插入到一个类中。
 */
//get_declared_traits — 返回所有已定义的 traits 的数组
//$r = get_declared_traits(); e($r, "get_declared_traits()");
//bool trait_exists ( string $traitname [, bool $autoload ] ) 检查指定的 trait 是否存在
//自 PHP 5.4.0 起，PHP 实现了一种代码复用的方法，称为 trait。
trait trait0{
    function e1(){
        echo "trait0 e1 <br />";
    }
}
trait trait00{
    function e2(){
        echo "trait00 e2 <br />";
    }
}

trait trait1{
    use trait0,trait00;
    function e3(){
        echo "trait1 e3 <br />";
        echo $this->e."<br />";
    }
}

trait trait2{
    function e1(){
        echo "trait2 e1 <br />";
    }
    
    function e2(){
        echo "trait2 e2 <br />";
    }
}

trait trait3{
    //冲突解决
    use trait1,trait2{
        trait1::e1 insteadof trait2;
        trait2::e2 insteadof trait1;
        trait1::e3 as e33;
    }
}

class T1{
    public $e = 12;
    use trait1,trait2{
        trait1::e1 insteadof trait2;
        trait2::e2 insteadof trait1;
        trait1::e3 as e33;
    }
}
class T2{
    public $e = 13;
    use trait3;
}

$r1 = new T1();
$r1->e1();
$r1->e2();
$r1->e3();
$r1->e33();

$r1 = new T2();
$r1->e1();
$r1->e2();
$r1->e3();
$r1->e33();