<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor. 
 */
include_once 'Menu.class';
$auth = array(
    'appid' => 'wxdd42a6cf5050a453',
    'appsecret' => 'af6a594dda07a6caeff9dc236c218b46'
);

$json = '{
            "button":[
                {	
                     "type":"click",
                     "name":"潮流生活",
                     "key":"click_caoliushenghuo"
                 },
                {
                     "name":"重庆",
                     "sub_button":[
                           {	
                               "type":"view",
                               "name":"重庆大学城",
                               "url":"https://baike.baidu.com/item/重庆大学城/7667103"
                            },
                            {
                                 "type":"view",
                                 "name":"沙坪坝",
                                 "url":"https://baike.baidu.com/item/沙坪坝区/2531479"
                             },
                            {
                                 "type":"view",
                                 "name":"九龙坡",
                                 "url":"https://baike.baidu.com/item/九龙坡区/2531861"
                             },
                            {
                                 "type":"click",
                                 "name":"重庆",
                                 "key":"click_cq"
                             }
                        ]
                 },
                 {
                       "type":"view",
                       "name":"网页开发",
                       "url":"http://535977672.applinzi.com/wap/sample.php"
                 }
            ]
        }';

$menu = new Menu($auth['appid'], $auth['appsecret']);
//创建菜单
if($_GET['type'] == 3){
    $r = $menu->create_menu($json); 
    if(empty($r) || $r["errcode"] > 0){
        echo "错误代码：".$r["errcode"]." ".$r["errmsg"];
    }else{
        var_dump($r);
        echo "成功";
    }
}

//查询菜单
if($_GET['type'] == 2){
    $r = $menu->get_menu();
    var_dump($r);
}