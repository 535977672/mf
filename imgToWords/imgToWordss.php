<?php
return;
set_time_limit(0);
ini_set('memory_limit', '2048M');
$imgDir = './img';
$vDir = './video/2.mp4';
$vNewDir = './video/2_1.mp4';
$frame = 27; //帧
//$kpbs = '-b 6179k';//码率

videoToImg($vDir, $imgDir, $frame);
fileToImg($imgDir);
imgToVideo($imgDir, $vNewDir, $frame, $kpbs);

function videoToImg($file, $imgDir, $frame = ''){
    fileToDel($imgDir);
    $str = "C:/ffmpeg/bin/ffmpeg -i ". $file ." -r " . $frame . " -ss 00:00:02 -t 00:00:13 ". $imgDir ."/%05d.jpg";
    exec($str);
    echo 'videoToImg end;';
}


function imgToVideo($imgDir, $vNewDir, $frame = '', $kpbs = ''){
    //threads以两个线程进行运行， 加快处理的速度。 -y覆盖
    $str = "C:/ffmpeg/bin/ffmpeg -threads 8 -y -f image2 -i ". $imgDir ."/%05d.jpg  -vcodec libx264 -r ". $frame ." ". $kpbs ." " . $vNewDir;
    exec($str);
    fileToDel($imgDir);
    echo 'imgToVideo end;';
}

function fileToDel($dir){
    if ($handle = opendir($dir)) {
        while (false !== ($file = readdir($handle))) {
            if($file != '.' && $file != '..'){
                $file = $dir . '/' . $file;
                unlink($file);
            }
        }
        closedir($handle);
        return true;
    }
}

function fileToImg($dir){
    if ($handle = opendir($dir)) {
        while (false !== ($file = readdir($handle))) {
            if($file != '.' && $file != '..'){
                $file = explode( '.', $file);
                $ofile = $dir . '/' . $file[0] . '.' . $file[1];
                $newfile = $dir . '/' . $file[0] . '_1.' . $file[1];
                $newfile = $ofile;
                image($ofile, $newfile);
            }
        }
        closedir($handle);
        return true;
    }
}


function image($file, $newfile){
    $types = array(1 => 'gif',2 => 'jpeg',3 => 'png',6 => 'bmp');
    $info = getimagesize($file); 
    $type = $types[$info[2]];
    $imagecreateFun = 'imagecreatefrom'.$type;
    $im = @$imagecreateFun($file) or die('Cannot Initialize new GD image stream');
    $w = imagesx($im);
    $h = imagesy($im);
    $image=@imagecreatetruecolor($w, $h) or die('Cannot Initialize new GD image stream');
    $background = imagecolorallocate($image, 255, 255, 255);// 设定一些颜色
    $black = imagecolorallocate($image, 0, 0, 0);
    imagefill($image,0,0,$background);
    $b = 6;
    $f = 14;
    $fontsize = 14;
    $font = 'C:\Windows\Fonts\AdobeHeitiStd-Regular.otf';
    for($i=$b; $i<$w; $i=$i+2*$b){
        for($j=$b; $j<$h; $j=$j+2*$b){
            $rgb = ImageColorAt($im, $i, $j);
            $color_tran = imagecolorsforindex($im, $rgb);
            $string = getStr($color_tran);
            imagechar($image, $f, $i, $j, $string, $black); //bool imagechar ( resource $image , int $font , int $x , int $y , string $c , int $color )水平地画一个字符  
            //imagettftext($image, $fontsize, 0, $i, $j, $black, $font, $string);
        }
    }
    $imageFun = 'image'.$type;
    if ($type == 'jpeg'){
        @$imageFun($image,$newfile,100) or die('保存失败!');
    } else {
        @$imageFun($image,$newfile) or die('保存失败!');
    }
    imagedestroy($image);
    imagedestroy($im);
    echo '+1';
    return true;
}

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