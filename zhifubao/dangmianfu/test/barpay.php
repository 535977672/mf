<?php
/**
 * 当面付  扫码枪扫条码支付
 * 条码支付
 |____config
| |____config.php  //配置文件（appid、密钥等）
|____log //日志文件夹
| |____log.txt
|____model
| |____builder
| | |____AlipayTradePayContentBuilder.php //条码支付请求bizContent结构体
| | |____AlipayTradePrecreateContentBuilder.php //扫码支付(生成二维码)请求bizContent结构体
| | |____AlipayTradeQueryContentBuilder.php //查询请求bizContent结构体
| | |____AlipayTradeRefundContentBuilder.php //退款请求bizContent结构体
| | |____AlipayTradeCancelContentBuilder.php //撤销请求bizContent结构体
| | |____ExtendParams.php //扩展参数构造类
| | |____GoodsDetail.php //商品详情参数构造类
| | |____RoyaltyDetailInfo.php //分润参数构造类
| |____result
| | |____AlipayF2FPayResult.php //条码支付应答
| | |____AlipayF2FPrecreateResult.php //扫码支付(生成二维码)应答
| | |____AlipayF2FQueryResult.php //查询应答
| | |____AlipayF2FRefundResult.php //退款应答
|____service
| |____AlipayTradeService.php //当面付2.0服务实现，包括条码支付（带轮询）、扫码支付、消费查询、消费退款
|____barpay_test.php //条码测试页面
 */
header("Content-type: text/html; charset=utf-8");
require_once '../dangmianfulib/f2fpay/model/builder/AlipayTradePayContentBuilder.php';//条码支付请求bizContent结构体
require_once '../dangmianfulib/f2fpay/service/AlipayTradeService.php';//当面付2.0服务实现，包括条码支付（带轮询）、扫码支付、消费查询、消费退款

    $config = array(
            //签名方式,默认为RSA2(RSA2048)
            //'sign_type' => "RSA1",
            'sign_type' => "RSA2",
            //支付宝公钥
            //'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAjcRSOwYrwmk6tXQhjp2CgWTKeNK+PEaUslrfqg/m0ijeVhp/fRZhDcd0nA2UiflBY5A98tUcxb+99yLBOOoQAqJQ/9qsZBYEDbDxL6G0G0eMbLmD7gNS6w2b9LfB0+TmsK5XJSEbidejPsg/KdAtg5zpRONiDowybyxn8shgppx9ZIYZonzIo5V4Ynqjv7e4lawF5QRg4wd/mPrTynrQAn62oz5SQJnpY89R6+GuGj5PraF5wVuK2xjMmL4M0ipDA1tGO6qUX4Pi972NcViVh3ijLExYRmMpF3gsG/QGUuoE2/8MwJjBl2xUQOgb0o+kOVLmtPMwWkZmjZzt37RxUwIDAQAB",
            //沙箱
            'alipay_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAooMpCOBN+Xk5rkeEgYd1eNrH/nTiUDnxJUvgKx/pociO+6A4rMfOK8V531Ws+fTr7EaNgQy1P8e4xvI1YReebc9T1st/8UtEfML8VD9z2HxryLPu7KwnuQf+YoaGiQtYjJ47vSSlS2NUsp4Tg+f0Xn7D/w9bttgHidkh4tiORONKogS3noAUT+gpELTpG+/0ueOFnT8aYJl9pcb7USuouCqmCt/zYHyPKkgjAZF0fBYI/+DDEr2WHl2Xc/47T4QXjerRn5eFTCYkKunU02NCg3LlUNKR4STsuho2eUcVzDIZoK1kC9Ujh3lKBPwwZsqQ0vKtGXEQi20dIAbZ/qPucQIDAQAB',
            //商户私钥
            //'merchant_private_key' => "MIIEogIBAAKCAQEAlnu4H0LSg9NTk/2+gralF0LQltX2ntDskguFvhbfZu6bHYCvoPpTDSSM7dDzQNBpc0McV8pzaXSlGkQ2UEo2Q+nFW0zTFVi54DkuoGFwbsLgtAuOAcH6FYKbZnKUqFpLPamnDM6dunMINpVCfhYvqh4+9z7DOPp3KzzFuUzVmqHVTOqih838WC8VXre2xjVNaHXsxrsgPoq6BlcoETw2K7BpPUmrOh0jTnvULsYQ22qqrzASrmBg3XlO5fkiOFrM6Pi2AblDTj7iCze88RJDV/2ph6Q+iGofHMCmPz8lhD+sTNi+9yv0nzFq/0DVzDeGv3wmfWFBOl2R7F+DIpF6XQIDAQABAoIBABuXM3sH1XE2HezUaUmuEzbgmT4OnNkhlT5xvmPL7coBlY8jORBa1T9jpDM2TGNl0u+/LkMqa166dEsMlqjB8pEhG35R56HSUsI5ucLOGr80G97m/3JzDldDSxrNh1QWuhTkNiyy9VhqHudjFn3ns3WNdh3+8+xOf+r9iYMgA0oGegvoPJLNrKy4DhWu/G1rv713J4fNLFxh7FHXjK6YO2Aw6dgVQvff/mFykBjTvIRZfRcWOGxlBCUf3HaXp7cGDOur59SF/TlAmFwD0KUI0NiAZcvCOEnbsDQJD25fpQmsmp+9k5gdmoHOwtaAhv49J2FdL+xdwyGtUX2x1sr9GEECgYEAxQHrs1sEgNe6NMZAAvueCt4sO5dB/RBBJGeN6ly0GrIU4j3gIyEz8TVlaX0WVSHlp1sF9FAms6qR6wQKpBDzZkSHYspUWYwIn7xV7sn9I7PAGnoxWTHXlPLHjix9KHq/uj9pVo5ELI3lfu+zQcmG3OYATWIUaFBInGTrU1cth38CgYEAw4tfkCzo2rn23OTjCL8q68K6E2F7b1WGapbdCx/NxmqwG23gQ00AlUNWINJUQ5AlMgRUDqHGG21zHd1plgsomF+87PGPfFpKVia9ZwTLBxH6Gd9CZ6MveHGzexxScshbYUHBfRUGEFivBNUw6Zjt5uX/vaH/Izzn5UXvJfoCDCMCgYAa8XdN0T3dbSOPQinQ/p6Pt/DuuXIR7R4rn2n+Sm1rVT2b74Bu7YSQEZBsC+p4/CjPaZh34FpaqhJIxQW7iIHxU5/8d9VvZcJsLjLGdKOFNXkpZdrH6xQjz8xQ+m6nkZoVG8UJTG2wdjuTz66BadFi9qXF74sA9THpCbhRbpPQewKBgGvLBbf1ebsxLktghWLJ9wAVzPtoDmI2NC3H0jwSoR2SrFfCfxC6furJPs5DA55m9IoY5rlWJl3yPLYm2tCSgCNXC09WbfFv2HCbVGdYtg7EsyjV8MYup7lufDEOUMjjd7QqSl4IW9pg+MHiP99VpTdWbF790SZ8qZyyq300zzIfAoGACcu77bRUO5tc8T1INqp7zLr+uMR4k1hhhljayOTPP9S5juLE+a1BgkO6fGme0LcTswUtt/fqfb3i/jTJDvMqc2jrO98HnpLbp6UL07t/tnO0/kKjXrUxv2uMuI3zWS34b0YssV7OTTsPR2NCZXqrd//bWJSA48ARp+ote2Gta6A=",
            //沙箱
            'merchant_private_key' => "MIIEowIBAAKCAQEAooMpCOBN+Xk5rkeEgYd1eNrH/nTiUDnxJUvgKx/pociO+6A4rMfOK8V531Ws+fTr7EaNgQy1P8e4xvI1YReebc9T1st/8UtEfML8VD9z2HxryLPu7KwnuQf+YoaGiQtYjJ47vSSlS2NUsp4Tg+f0Xn7D/w9bttgHidkh4tiORONKogS3noAUT+gpELTpG+/0ueOFnT8aYJl9pcb7USuouCqmCt/zYHyPKkgjAZF0fBYI/+DDEr2WHl2Xc/47T4QXjerRn5eFTCYkKunU02NCg3LlUNKR4STsuho2eUcVzDIZoK1kC9Ujh3lKBPwwZsqQ0vKtGXEQi20dIAbZ/qPucQIDAQABAoIBAGPM9otL7LbTOpgLtZUyUfMJMJ7UuxMXsj78TMtPCtRe7Wgb6hI5liSNXp3H6LWMMsJkRYxF+J0VkyUiI6PftFytYUhcqtLNLV8NA5bdbNA7AJo93fGce7yG6zMoeEB7JkMc/YTXl2cntiEHMOblsM3DPaxKi0FLg72lCclcwmoMzPg19rBzg2ly/gQRV5lu3C5Ovq/LAcIOjuyyfN2s3fc1ZyZXx6x2TXPH+xg6wda4F5K4uoyS1nefsu5Kcvx8vWcL+hhXMJkjhKPtJhyPFcD2w9p3pBfKEyNdzxciAaezDxPRY/TGHUX9YCXsuma4E6b9QI5nSeLK/1bRnTANfP0CgYEA0IVdpiyXbySVU990LbzckD0O5m8Qp7plv0tstRHeh/KagAz2FbzJI8Vh1/KVVU8RXwF/7gkuPOX1ajjfnvDe8LInBNBNSCEybdX8e/XewnE67tXsX48E3AhBZT2wg1edVfj9jppQ7rHKfrDSSBkWxT2qRZ3vuG4A9/wlwOEFlD8CgYEAx4P2wYNzSm1qTqgH3OGQJDfCi27sPfAA6kdJc/x26fRc6RbsofFKApnHpeUJbY/3T58oBDghdd24l35Ebg7E13Paiel4CvrGcCHJy/vH2HqBdk29xUa06bahazuLBBkSOx92b6BUtefjsGvGhoLMcNCxTUJmUM5SPK0OD+AtEU8CgYAZwL7mLQ+u3FfM+gYBOBgNgFz8vK7T6EN0sr4ERuay55WJRxCFcsFst43z+7PRy2gb0bWZEm0xfD0pF0kW+iyukXIcOBWzWNY/lnQOYzlVzmI26Ri+XI1/F03sUQgh0IpP+eZm3EwujqqxpujxmpejWJBU9MKMhpl8BxoqjiAARQKBgARMb5CTyHQeD2BKdoDnyzc8jFB8v1JGTX6+snJxSg6YWTgcalTC4hlUPtzwJlfZ9jYc87vDidUERendqpPEdbE+qcK26QMzi/r2f2aJsjCT0x49Zo1NjLBMYwXwbnpUH/RuJRsalTimGl2+tLRJNSZpGKjVeWbcSyFLiTYGWnI5AoGBAMDPQYMUO+t2H5P22d68mvjDjNbBjoyC5Dj9fPcWGDHka+sETKrxmqIdmr8+Ax6NhyGuGz2locPpXwBYvRTpa5JzD1Oj8Z41iz15t141lC2xPhdFlcigQxegLzzOeFFfaUBywhLVMCH22w527yTM9tO7Sp7I2gnW/yl5wd1AFn2y",
            //编码格式
            'charset' => "UTF-8",
            //支付宝网关
            //'gatewayUrl' => "https://openapi.alipay.com/gateway.do",
            'gatewayUrl' => "https://openapi.alipaydev.com/gateway.do",//沙箱
            //应用ID
            //'app_id' => "2017061607504664",
            'app_id' => "2016073000123483",//沙箱

            //异步通知地址,只有扫码支付预下单可用
            'notify_url' => "",
            //最大查询重试次数
            'MaxQueryRetry' => "10",
            //查询间隔
            'QueryDuration' => "3"
        );

//if (!empty($_POST['out_trade_no'])&& trim($_POST['out_trade_no'])!="") {

    // (必填) 商户网站订单系统中唯一订单号，64个字符以内，只能包含字母、数字、下划线，
    // 需保证商户系统端不能重复，建议通过数据库sequence生成，
    //$outTradeNo = "barpay" . date('Ymdhis') . mt_rand(100, 1000);
    $outTradeNo = "barpay_dingdanhao" . date('Ymdhis') . mt_rand(100, 1000);

    // (必填) 订单标题，粗略描述用户的支付目的。如“XX品牌XXX门店消费”
    $subject = '订单标题测试消费subject';

    // (必填) 订单总金额，单位为元，不能超过1亿元
    // 如果同时传入了【打折金额】,【不可打折金额】,【订单总金额】三者,则必须满足如下条件:【订单总金额】=【打折金额】+【不可打折金额】
    $totalAmount = $_POST['totalAmount']?$_POST['totalAmount']:0.01;

    // (必填) 付款条码，用户支付宝钱包手机app点击“付款”产生的付款条码
    //28开头18位数字
    $authCode = $_POST['code']; //'280153797918315303'; 

    // (可选,根据需要使用) 订单可打折金额，可以配合商家平台配置折扣活动，如果订单部分商品参与打折，可以将部分商品总价填写至此字段，默认全部商品可打折
    // 如果该值未传入,但传入了【订单总金额】,【不可打折金额】 则该值默认为【订单总金额】- 【不可打折金额】
    //String discountableAmount = "1.00"; //

    // (可选) 订单不可打折金额，可以配合商家平台配置折扣活动，如果酒水不参与打折，则将对应金额填写至此字段
    // 如果该值未传入,但传入了【订单总金额】,【打折金额】,则该值默认为【订单总金额】-【打折金额】
    //$undiscountableAmount = "0.01";

    // 卖家支付宝账号ID，用于支持一个签约账号下支持打款到不同的收款账号，(打款到sellerId对应的支付宝账号)
    // 如果该字段为空，则默认为与支付宝签约的商户的PID，也就是appid对应的PID
    $sellerId = '';//"2088102169111334";

    // 订单描述，可以对交易或商品进行一个详细地描述，比如填写"购买商品2件共15.00元"
    $body = "订单描述测试消费body";

    //商户操作员编号，添加此参数可以为商户操作员做销售统计
    //$operatorId = "operatorId";

    // (可选) 商户门店编号，通过门店号和商家后台可以配置精准到门店的折扣信息，详询支付宝技术支持
    //$storeId = "store_id";

    // 支付宝的店铺编号
    //$alipayStoreId = "alipay_store_id";

    // 业务扩展参数，目前可添加由支付宝分配的系统商编号(通过setSysServiceProviderId方法)，详情请咨询支付宝技术支持
    //$providerId = ""; //系统商pid,作为系统商返佣数据提取的依据
    //$extendParams = new ExtendParams();
    //$extendParams->setSysServiceProviderId($providerId);
    //$extendParamsArr = $extendParams->getExtendParams();

    // 支付超时，线下扫码交易定义为5分钟
    $timeExpress = "5m";

    // 商品明细列表，需填写购买商品详细信息，
    //$goodsDetailList = array();

    // 创建一个商品信息，参数含义分别为商品id（使用国标）、名称、单价（单位为分）、数量，如果需要添加商品类别，详见GoodsDetail
    //$goods1 = new GoodsDetail();
    //$goods1->setGoodsId("good_id001");
    //$goods1->setGoodsName("XXX商品1");
    //$goods1->setPrice(3000);
    //$goods1->setQuantity(1);
    //得到商品1明细数组
    //$goods1Arr = $goods1->getGoodsDetail();

    // 继续创建并添加第一条商品信息，用户购买的产品为“xx牙刷”，单价为5.05元，购买了两件
    //$goods2 = new GoodsDetail();
    //$goods2->setGoodsId("good_id002");
    //$goods2->setGoodsName("XXX商品2");
    //$goods2->setPrice(1000);
    //$goods2->setQuantity(1);
    //得到商品1明细数组
    //$goods2Arr = $goods2->getGoodsDetail();

    //$goodsDetailList = array($goods1Arr, $goods2Arr);

    //第三方应用授权令牌,商户授权系统商开发模式下使用
    $appAuthToken = "";//根据真实值填写

    // 创建请求builder，设置请求参数
    $barPayRequestBuilder = new AlipayTradePayContentBuilder();
    $barPayRequestBuilder->setOutTradeNo($outTradeNo);
    $barPayRequestBuilder->setTotalAmount($totalAmount);
    $barPayRequestBuilder->setAuthCode($authCode);
    $barPayRequestBuilder->setTimeExpress($timeExpress);
    $barPayRequestBuilder->setSubject($subject);
    $barPayRequestBuilder->setBody($body);
    //$barPayRequestBuilder->setUndiscountableAmount($undiscountableAmount);
    //$barPayRequestBuilder->setExtendParams($extendParamsArr);
    //$barPayRequestBuilder->setGoodsDetailList($goodsDetailList);
    //$barPayRequestBuilder->setStoreId($storeId);
    //$barPayRequestBuilder->setOperatorId($operatorId);
    //$barPayRequestBuilder->setAlipayStoreId($alipayStoreId);

    $barPayRequestBuilder->setAppAuthToken($appAuthToken);

    // 调用barPay方法获取当面付应答
    $barPay = new AlipayTradeService($config);
    $barPayResult = $barPay->barPay($barPayRequestBuilder);

    switch ($barPayResult->getTradeStatus()) {
        case "SUCCESS":
            echo "支付宝支付成功:" . "<br>--------------------------<br>";
            print_r($barPayResult->getResponse());
            break;
            //支付宝支付成功:
            //--------------------------
            //stdClass Object ( 
            //[code] => 10000 [msg] => Success 
            //[buyer_logon_id] => 183****8987 
            //[buyer_pay_amount] => 0.01 
            //[buyer_user_id] => 2088702494135696 
            //[fund_bill_list] => Array ( 
            //  [0] => stdClass Object ( 
            //      [amount] => 0.01 
            //      [fund_channel] => ALIPAYACCOUNT 
            //      ) ) 
            //[gmt_payment] => 2017-06-26 15:56:46 
            //[invoice_amount] => 0.01 
            //[open_id] => 20881035860536292439276830517569 
            //[out_trade_no] => barpay_dingdanhao20170626095645518 
            //[point_amount] => 0.00 
            //[receipt_amount] => 0.01 
            //[total_amount] => 0.01 
            //[trade_no] => 2017062621001004690246237582 
            //)
        case "FAILED":
            echo "支付宝支付失败!!!" . "<br>--------------------------<br>";
            if (!empty($barPayResult->getResponse())) {
                print_r($barPayResult->getResponse());
                //stdClass Object
                //(
                //    [code] => 40004
                //    [msg] => Business Failed
                //    [sub_code] => ACQ.INVALID_STORE_ID
                //    [sub_msg] => 支付失败，门店号不存在，请联系管理员处理。[INVALID_STORE_ID]
                //    [buyer_pay_amount] => 0.00
                //    [invoice_amount] => 0.00
                //    [out_trade_no] => barpay_dingdanhao20170622114035435
                //    [point_amount] => 0.00
                //    [receipt_amount] => 0.00
                //)
            }
            break;
        case "UNKNOWN":
            echo "系统异常，订单状态未知!!!" . "<br>--------------------------<br>";
            if (!empty($barPayResult->getResponse())) {
                print_r($barPayResult->getResponse());
            }
            break;
        default:
            echo "不支持的交易状态，交易返回异常!!!";
            break;
    }
    return;
//}