<?php
return;
$file = '1.jpg';
$info = getimagesize($file); 
//var_dump($info);
//array(7) {
//  [0]=>
//  int(430) //图像宽度的像素值
//  [1]=>
//  int(430) //图像高度的像素值
//  [2]=>
//  int(2) //1 = GIF，2 = JPG，3 = PNG，4 = SWF，5 = PSD，6 = BMP...
//  [3]=>
//  string(24) "width="430" height="430"" //文本字符串
//  ["bits"]=>
//  int(8)
//  ["channels"]=>
//  int(3) //对于 JPG 图像，还会多返回两个索引：channels 和 bits。channels 对于 RGB 图像其值为 3，对于 CMYK 图像其值为 4。bits 是每种颜色的位数。
//  ["mime"]=>
//  string(10) "image/jpeg"
//}

$im = @imagecreatefromjpeg($file) or die('Cannot Initialize new GD image stream');
//var_dump($im);//resource(4) of type (gd)
$w = imagesx($im);
$h = imagesy($im);

//$rgb = ImageColorAt($im, 100, 100);//取得某像素的颜色索引值 imagecolorset
//$r = ($rgb >> 16) & 0xFF;
//$g = ($rgb >> 8) & 0xFF;
//$b = $rgb & 0xFF;
//// 使其可读
//$color_tran = imagecolorsforindex($im, $rgb); //array(4) { ["red"]=> int(190) ["green"]=> int(185) ["blue"]=> int(189) ["alpha"]=> int(0) }
//var_dump($rgb, $r, $g, $b, $color_tran); //int(12499389) int(190) int(185) int(189) 

$image=@imagecreatetruecolor($w, $h) or die('Cannot Initialize new GD image stream');
//$image=@imagecreate($w, $h) or die('Cannot Initialize new GD image stream');
// 背景设为红色
$background = imagecolorallocate($image, 255, 255, 255);// 设定一些颜色
$black = imagecolorallocate($image, 0, 0, 0);
imagefill($image,0,0,$background);
$b = 4;
for($i=$b; $i<$w; $i=$i+2*$b){
    for($j=$b; $j<$h; $j=$j+2*$b){
        $rgb = ImageColorAt($im, $i, $j);
        $color_tran = imagecolorsforindex($im, $rgb);
        $string = getStr($color_tran);
        imagechar($image, 1, $i, $j, $string, $black); //bool imagechar ( resource $image , int $font , int $x , int $y , string $c , int $color )水平地画一个字符  
    }
}
header('Content-type: image/jpeg');
imagejpeg($image);
imagedestroy($image);


function getStr($c){
    $str = ' ';
    $r = region($c["red"]);
    $g = region($c["green"]);
    $b = region($c["blue"]);
    $str = char($r.$g.$b);
    return $str;
}

function region($r){
    return $r/5;
}
function char($r){
    $c = '';
    $s = ' ABCDEFGHIJKLMNOPQRSTUVWXYZ&%$#@';
    $c = $s[$r/32];
    return $c;
}




