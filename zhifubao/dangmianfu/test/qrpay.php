<?php 
/**
 * 当面付  扫码支付 手机扫商家二维码支付
 * 手机扫商家二维码支付
 */
header("Content-type: text/html; charset=utf-8");
require_once '../dangmianfulib/f2fpay/model/builder/AlipayTradePrecreateContentBuilder.php';//扫码支付(生成二维码)请求bizContent结构体
require_once '../dangmianfulib/f2fpay/service/AlipayTradeService.php';//当面付2.0服务实现，包括条码支付（带轮询）、扫码支付、消费查询、消费退款
require_once 'phpqrcode.php';

    $config = array(
        //签名方式,默认为RSA2(RSA2048)
        //'sign_type' => "RSA1",
        'sign_type' => "RSA2",
        //沙箱
        'alipay_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAooMpCOBN+Xk5rkeEgYd1eNrH/nTiUDnxJUvgKx/pociO+6A4rMfOK8V531Ws+fTr7EaNgQy1P8e4xvI1YReebc9T1st/8UtEfML8VD9z2HxryLPu7KwnuQf+YoaGiQtYjJ47vSSlS2NUsp4Tg+f0Xn7D/w9bttgHidkh4tiORONKogS3noAUT+gpELTpG+/0ueOFnT8aYJl9pcb7USuouCqmCt/zYHyPKkgjAZF0fBYI/+DDEr2WHl2Xc/47T4QXjerRn5eFTCYkKunU02NCg3LlUNKR4STsuho2eUcVzDIZoK1kC9Ujh3lKBPwwZsqQ0vKtGXEQi20dIAbZ/qPucQIDAQAB',
        //沙箱
        'merchant_private_key' => "MIIEowIBAAKCAQEAooMpCOBN+Xk5rkeEgYd1eNrH/nTiUDnxJUvgKx/pociO+6A4rMfOK8V531Ws+fTr7EaNgQy1P8e4xvI1YReebc9T1st/8UtEfML8VD9z2HxryLPu7KwnuQf+YoaGiQtYjJ47vSSlS2NUsp4Tg+f0Xn7D/w9bttgHidkh4tiORONKogS3noAUT+gpELTpG+/0ueOFnT8aYJl9pcb7USuouCqmCt/zYHyPKkgjAZF0fBYI/+DDEr2WHl2Xc/47T4QXjerRn5eFTCYkKunU02NCg3LlUNKR4STsuho2eUcVzDIZoK1kC9Ujh3lKBPwwZsqQ0vKtGXEQi20dIAbZ/qPucQIDAQABAoIBAGPM9otL7LbTOpgLtZUyUfMJMJ7UuxMXsj78TMtPCtRe7Wgb6hI5liSNXp3H6LWMMsJkRYxF+J0VkyUiI6PftFytYUhcqtLNLV8NA5bdbNA7AJo93fGce7yG6zMoeEB7JkMc/YTXl2cntiEHMOblsM3DPaxKi0FLg72lCclcwmoMzPg19rBzg2ly/gQRV5lu3C5Ovq/LAcIOjuyyfN2s3fc1ZyZXx6x2TXPH+xg6wda4F5K4uoyS1nefsu5Kcvx8vWcL+hhXMJkjhKPtJhyPFcD2w9p3pBfKEyNdzxciAaezDxPRY/TGHUX9YCXsuma4E6b9QI5nSeLK/1bRnTANfP0CgYEA0IVdpiyXbySVU990LbzckD0O5m8Qp7plv0tstRHeh/KagAz2FbzJI8Vh1/KVVU8RXwF/7gkuPOX1ajjfnvDe8LInBNBNSCEybdX8e/XewnE67tXsX48E3AhBZT2wg1edVfj9jppQ7rHKfrDSSBkWxT2qRZ3vuG4A9/wlwOEFlD8CgYEAx4P2wYNzSm1qTqgH3OGQJDfCi27sPfAA6kdJc/x26fRc6RbsofFKApnHpeUJbY/3T58oBDghdd24l35Ebg7E13Paiel4CvrGcCHJy/vH2HqBdk29xUa06bahazuLBBkSOx92b6BUtefjsGvGhoLMcNCxTUJmUM5SPK0OD+AtEU8CgYAZwL7mLQ+u3FfM+gYBOBgNgFz8vK7T6EN0sr4ERuay55WJRxCFcsFst43z+7PRy2gb0bWZEm0xfD0pF0kW+iyukXIcOBWzWNY/lnQOYzlVzmI26Ri+XI1/F03sUQgh0IpP+eZm3EwujqqxpujxmpejWJBU9MKMhpl8BxoqjiAARQKBgARMb5CTyHQeD2BKdoDnyzc8jFB8v1JGTX6+snJxSg6YWTgcalTC4hlUPtzwJlfZ9jYc87vDidUERendqpPEdbE+qcK26QMzi/r2f2aJsjCT0x49Zo1NjLBMYwXwbnpUH/RuJRsalTimGl2+tLRJNSZpGKjVeWbcSyFLiTYGWnI5AoGBAMDPQYMUO+t2H5P22d68mvjDjNbBjoyC5Dj9fPcWGDHka+sETKrxmqIdmr8+Ax6NhyGuGz2locPpXwBYvRTpa5JzD1Oj8Z41iz15t141lC2xPhdFlcigQxegLzzOeFFfaUBywhLVMCH22w527yTM9tO7Sp7I2gnW/yl5wd1AFn2y",
        //编码格式
        'charset' => "UTF-8",
        'gatewayUrl' => "https://openapi.alipaydev.com/gateway.do",//沙箱
        //应用ID
        'app_id' => "2016073000123483",//沙箱

        //异步通知地址,只有扫码支付预下单可用
        'notify_url' => "",
        //最大查询重试次数
        'MaxQueryRetry' => "10",
        //查询间隔
        'QueryDuration' => "3"
    );
	// (必填) 商户网站订单系统中唯一订单号，64个字符以内，只能包含字母、数字、下划线，
	// 需保证商户系统端不能重复，建议通过数据库sequence生成，
	$outTradeNo = "qrpay_dingdanhao".date('Ymdhis').mt_rand(100,1000);

	// (必填) 订单标题，粗略描述用户的支付目的。如“xxx品牌xxx门店当面付扫码消费”
	$subject = '订单标题测试消费subject';

	// (必填) 订单总金额，单位为元，不能超过1亿元
	// 如果同时传入了【打折金额】,【不可打折金额】,【订单总金额】三者,则必须满足如下条件:【订单总金额】=【打折金额】+【不可打折金额】
	$totalAmount = $_POST['totalAmount']?$_POST['totalAmount']:0.01;

	// 订单描述，可以对交易或商品进行一个详细地描述，比如填写"购买商品2件共15.00元"
	$body = "订单描述测试消费body";

	// 支付超时，线下扫码交易定义为5分钟
	$timeExpress = "5m";

	//第三方应用授权令牌,商户授权系统商开发模式下使用
	$appAuthToken = "";//根据真实值填写

	// 创建请求builder，设置请求参数
	$qrPayRequestBuilder = new AlipayTradePrecreateContentBuilder();
	$qrPayRequestBuilder->setOutTradeNo($outTradeNo);
	$qrPayRequestBuilder->setTotalAmount($totalAmount);
	$qrPayRequestBuilder->setTimeExpress($timeExpress);
	$qrPayRequestBuilder->setSubject($subject);
	$qrPayRequestBuilder->setBody($body);

	$qrPayRequestBuilder->setAppAuthToken($appAuthToken);


	// 调用qrPay方法获取当面付应答
	$qrPay = new AlipayTradeService($config);
	$qrPayResult = $qrPay->qrPay($qrPayRequestBuilder);
    //var_dump($qrPayResult);
    //{"code":"10000","msg":"Success","out_trade_no":"qrpay_dingdanhao20170630042252139","qr_code":"https://qr.alipay.com/bax00237rqud0vacoiyc0037"}
    //订单二维码（有效时间2小时）的内容，开发者需要自己使用工具根据内容生成二维码图片
    
    /**
     * 生成二维码图片
	 */
    //$url = 'https://qr.alipay.com/bax00237rqud0vacoiyc0037';
    //QRcode::png($url);
    //exit();
    
	//	根据状态值进行业务处理
	switch ($qrPayResult->getTradeStatus()){
		case "SUCCESS":
			echo "支付宝创建订单二维码成功:"."<br>---------------------------------------<br>";
			$response = $qrPayResult->getResponse();
			$qrcode = $qrPay->create_erweima($response->qr_code);
			echo $qrcode;
			print_r($response);
			
			break;
		case "FAILED":
			echo "支付宝创建订单二维码失败!!!"."<br>--------------------------<br>";
			if(!empty($qrPayResult->getResponse())){
				print_r($qrPayResult->getResponse());
			}
			break;
		case "UNKNOWN":
			echo "系统异常，状态未知!!!"."<br>--------------------------<br>";
			if(!empty($qrPayResult->getResponse())){
				print_r($qrPayResult->getResponse());
			}
			break;
		default:
			echo "不支持的返回状态，创建订单二维码返回异常!!!";
			break;
	}
	return ;