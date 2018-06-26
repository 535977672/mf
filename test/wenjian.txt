【微信支付】API对应的SDK和调用示例 刷卡支付、公众号支付、扫码支付 

SDK
体验地址
http://paysdk.weixin.qq.com/

快速搭建指南
①、安装配置nginx+phpfpm+php
②、建SDK解压到网站根目录
③、修改lib/WxPay.Config.php为自己申请的商户号的信息（配置详见说明）
⑤、下载证书替换cert下的文件
⑥、搭建完成

SDK目录结构
|-- cert
|   |-- apiclient_cert.pem
|   `-- apiclient_key.pem
|-- download.php
|-- index.php
|-- lib
|   |-- WxPay.Api.php
|   |-- WxPay.Config.php
|   |-- WxPay.Data.php
|   |-- WxPay.Exception.php
|   `-- WxPay.Notify.php
|-- logs
|   |-- 2015-03-06.log
|   `-- 2015-03-11.log
|-- micropay.php
|-- native.php
|-- native_notify.php
|-- notify.php
|-- orderquery.php
|-- qrcode.php
|-- refund.php
|-- refundquery.php
|-- unifiedorder.php
`-- unit
    |-- WxPay.JsApiPay.php
    |-- WxPay.MicroPay.php
    |-- WxPay.NativePay.php
    |-- log.php
    `-- phpqrcode

目录功能简介
lib
API接口封装代码
WxPay.Api.php 包括所有微信支付API接口的封装
WxPay.Config.php  商户配置
WxPay.Data.php   输入参数封装
WxPay.Exception.php  异常类
WxPay.Notify.php    回调通知基类

cert
证书存放路径，证书可以登录商户平台https://pay.weixin.qq.com/index.php/account/api_cert下载

unit
工具类

unit/phpqrcode
开源二维码php代码

logs
日志文件


配置指南
MCHID = '1225312702';
这里填开户邮件中的商户号

APPID = 'wx426b3015555a46be';
这里填开户邮件中的（公众账号APPID或者应用APPID）

KEY = 'e10adc3949ba59abbe56e057f20f883e'
这里请使用商户平台登录账户和密码登录http://pay.weixin.qq.com 平台设置的“API密钥”，为了安全，请设置为32字符串。

APPSECRET = '01c6d59a3f9024db6336662ac95c8e74'
改参数在JSAPI支付（open平台账户不能进行JSAPI支付）的时候需要用来获取用户openid，可使用APPID对应的公众平台登录http://mp.weixin.qq.com 的开发者中心获取AppSecret。



刷卡支付
用户打开微信钱包的刷卡的界面，商户扫码后提交完成支付

公众号支付
用户在微信内进入商家H5页面，页面内调用JSSDK完成支付

扫码支付
用户打开"微信扫一扫“，扫描商户的二维码后完成支付

APP支付
商户APP中集成微信SDK，用户点击后跳转到微信内完成支付

WAP H5支付
用户在微信以外的手机浏览器请求微信支付的场景唤起微信支付

小程序支付
用户在微信小程序中使用微信支付的场景