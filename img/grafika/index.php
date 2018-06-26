<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'src/autoloader.php';
use Grafika\Grafika;
use Grafika\Color;
//创建Editors
$editor = Grafika::createEditor();
//直接打开图像
//$editor->open( $image1, 'img/1.jpg');
//$editor->resizeFit($image1 , 200 , 200);//等比例缩放类型 那么就保证图片较长的一边不超过 (1000 3114)
//$editor->resizeExact($image1 , 200 , 200);//固定尺寸缩放类型。就是不管图片长宽比，全部缩小到200px，可能导致图片变形。
//$editor->resizeFill($image1 , 200,200);//居中剪裁。就是把较短的变缩放到200px，然后将长边的大于200px的部分居中剪裁掉，图片不会变形。
//$editor->save($image1 , 'img/1_resizeFit.jpg');
//$editor->free( $image1 );


/*
    blend()
    第一个参数为基础图片
    第二个参数为放置在基础图片之上的图片normal, multiply, overlay or screen.，这里的类型意思就是图片叠加的模式，下面会给出实例看每种的不同。
    第三个参数为透明度，这个不说太多，容易想到。
    第四个为位置，有10个选择，其中，前面9种为用户自定义拜访位置，而最后一个是智能拜访，由grafika来判断摆放在哪里好。 top-left, top-center, top-right, center-left, center, center-right, bottom-left, bottom-center, bottom-right and smart
    第五个参数为可选参数，表示图片2距离图片1左边的距离
    第六个参数也为可选参数，表示图片2距离图片1上边的距离

    text()
    image：所需要写文字的图片
    text：需要写的文字
    size：（选填）字体大小，默认为12px
    x：（选填）文字的最左边距离图片最左边的距离，默认为0
    y：（选填）文字的基线到图片的最上边的距离，默认是12px，也就是文字的高度。（基线你就当做文字最下面好了）
    color：（选填）字体颜色，Color对象，需要new Color一下，默认为黑色。
    font：（选填）字体的完整路径，默认Sans font.
    angle：（选填）文字旋转角度，取值范围为0-359，默认为0，也就是不旋转   
 */
$editor->open($image1 , 'img/1.jpg');
$editor->open($image2 , 'img/1_2.jpg');
$editor->open($image3 , 'img/1_3.jpg');
$editor->open($image4 , 'img/1_4.jpg');
$editor->open($image6 , 'img/1_6_1.jpg');
$editor->open($image61 , 'img/1_6_1.jpg');
$editor->open($image7 , 'img/1_7_1.jpg');
$editor->open($image71 , 'img/1_7_1.jpg');

$editor->resizeFill($image2 , 265,534);
$editor->resizeFill($image3 , 265,534);
$editor->resizeFill($image4 , 265,534);
$editor->resizeFill($image6 , 430,430);
$editor->resizeFill($image61 , 497,497);
$editor->resizeFill($image7 , 497,497);
$editor->resizeFill($image71 , 497,497);



$editor->blend ( $image1, $image2 , 'normal', 0.9, 'top-left',98, 816);
$editor->blend ( $image1, $image3 , 'normal', 0.9, 'top-left',368, 816);
$editor->blend ( $image1, $image4 , 'normal', 0.9, 'top-left',638, 816);
$editor->blend ( $image1, $image6 , 'normal', 0.9, 'top-left',282, 100);
$editor->blend ( $image1, $image61 , 'normal', 0.9, 'top-left',407, 2061);
$editor->blend ( $image1, $image7 , 'normal', 0.9, 'top-left',96, 1559);
$editor->blend ( $image1, $image71 , 'normal', 0.9, 'top-left',96, 2528);

$editor->text($image1 ,'拼图测试',12,645,2699,new Color("#000000"),'',0);
$editor->save($image1,'img/1_1_2.jpg');
$editor->free( $image1 );
$editor->free( $image2 );
$editor->free( $image3 );
$editor->free( $image4 );
$editor->free( $image6 );
$editor->free( $image61 );
$editor->free( $image7 );
$editor->free( $image71 );

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>tdnt</title>
</head>
<body>
    <img src="img/1_1_2.jpg">
    
    <img src="img/1.jpg">
</body>
</html>

