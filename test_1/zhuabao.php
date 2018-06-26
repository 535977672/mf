<?php

/* 
 * 抓包、采集测试
 */
header("Content-type: text/html; charset=gb2312"); 
date_default_timezone_set("Asia/Shanghai");
set_time_limit(0);
ini_set('memory_limit', '1024M');
session_start();

//while(!t()){
//   sleep(60);
//}

function t() {
    $u = 'http://www.exam8.com/yixue/yishi/chongqing/chengji/';
    
//    $ch = curl_init();
//    curl_setopt($ch, CURLOPT_URL, $u);
//    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//不输出 给变量
//    $res = curl_exec($ch);
//    curl_close($ch);
    
    $res = file_get_contents($u);
    
    $res = htmlspecialchars($res,ENT_QUOTES,'gb2312');
    preg_match('/lbcontent[\s\S]*?lbpage/', $res, $r);
    preg_match('/2018-06-([0-9]{2})/', $r[0], $re);
    if($re[1]>11){
        return $re[1];
    }
    return false;
}