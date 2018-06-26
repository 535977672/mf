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
//require_once '../dangmianfulib/f2fpay/model/builder/AlipayTradePayContentBuilder.php';//条码支付请求bizContent结构体
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

//if (!empty($_POST['out_trade_no'])&& trim($_POST['out_trade_no'])!=""){
    ////获取商户订单号
    $out_trade_no = trim($_POST['code']);

    //第三方应用授权令牌,商户授权系统商开发模式下使用
    $appAuthToken = "";//根据真实值填写

    //构造查询业务请求参数对象
    $queryContentBuilder = new AlipayTradeQueryContentBuilder();//查询请求bizContent结构体
    $queryContentBuilder->setOutTradeNo($out_trade_no);

    $queryContentBuilder->setAppAuthToken($appAuthToken);


    //初始化类对象，调用queryTradeResult方法获取查询应答
    $queryResponse = new AlipayTradeService($config);
    $queryResult = $queryResponse->queryTradeResult($queryContentBuilder);

    //var_dump($queryResult);
    
    //根据查询返回结果状态进行业务处理
//    switch ($queryResult->getTradeStatus()){
//        case "SUCCESS":
//            echo "支付宝查询交易成功:"."<br>--------------------------<br>";
//            print_r($queryResult->getResponse());
//            break;
//        case "FAILED":
//            echo "支付宝查询交易失败或者交易已关闭!!!"."<br>--------------------------<br>";
//            if(!empty($queryResult->getResponse())){
//                print_r($queryResult->getResponse());
//            }
//            break;
//        case "UNKNOWN":
//            echo "系统异常，订单状态未知!!!"."<br>--------------------------<br>";
//            if(!empty($queryResult->getResponse())){
//                print_r($queryResult->getResponse());
//            }
//            break;
//        default:
//            echo "不支持的查询状态，交易返回异常!!!";
//            break;
//    }
    return ;
//}