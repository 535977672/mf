<?php
$config = array (
		//签名方式,默认为RSA2(RSA2048)
		'sign_type' => "RSA2",

		//支付宝公钥
		'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAooMpCOBN+Xk5rkeEgYd1eNrH/nTiUDnxJUvgKx/pociO+6A4rMfOK8V531Ws+fTr7EaNgQy1P8e4xvI1YReebc9T1st/8UtEfML8VD9z2HxryLPu7KwnuQf+YoaGiQtYjJ47vSSlS2NUsp4Tg+f0Xn7D/w9bttgHidkh4tiORONKogS3noAUT+gpELTpG+/0ueOFnT8aYJl9pcb7USuouCqmCt/zYHyPKkgjAZF0fBYI/+DDEr2WHl2Xc/47T4QXjerRn5eFTCYkKunU02NCg3LlUNKR4STsuho2eUcVzDIZoK1kC9Ujh3lKBPwwZsqQ0vKtGXEQi20dIAbZ/qPucQIDAQAB",

		//商户私钥
		'merchant_private_key' => "MIIEowIBAAKCAQEAooMpCOBN+Xk5rkeEgYd1eNrH/nTiUDnxJUvgKx/pociO+6A4rMfOK8V531Ws+fTr7EaNgQy1P8e4xvI1YReebc9T1st/8UtEfML8VD9z2HxryLPu7KwnuQf+YoaGiQtYjJ47vSSlS2NUsp4Tg+f0Xn7D/w9bttgHidkh4tiORONKogS3noAUT+gpELTpG+/0ueOFnT8aYJl9pcb7USuouCqmCt/zYHyPKkgjAZF0fBYI/+DDEr2WHl2Xc/47T4QXjerRn5eFTCYkKunU02NCg3LlUNKR4STsuho2eUcVzDIZoK1kC9Ujh3lKBPwwZsqQ0vKtGXEQi20dIAbZ/qPucQIDAQABAoIBAGPM9otL7LbTOpgLtZUyUfMJMJ7UuxMXsj78TMtPCtRe7Wgb6hI5liSNXp3H6LWMMsJkRYxF+J0VkyUiI6PftFytYUhcqtLNLV8NA5bdbNA7AJo93fGce7yG6zMoeEB7JkMc/YTXl2cntiEHMOblsM3DPaxKi0FLg72lCclcwmoMzPg19rBzg2ly/gQRV5lu3C5Ovq/LAcIOjuyyfN2s3fc1ZyZXx6x2TXPH+xg6wda4F5K4uoyS1nefsu5Kcvx8vWcL+hhXMJkjhKPtJhyPFcD2w9p3pBfKEyNdzxciAaezDxPRY/TGHUX9YCXsuma4E6b9QI5nSeLK/1bRnTANfP0CgYEA0IVdpiyXbySVU990LbzckD0O5m8Qp7plv0tstRHeh/KagAz2FbzJI8Vh1/KVVU8RXwF/7gkuPOX1ajjfnvDe8LInBNBNSCEybdX8e/XewnE67tXsX48E3AhBZT2wg1edVfj9jppQ7rHKfrDSSBkWxT2qRZ3vuG4A9/wlwOEFlD8CgYEAx4P2wYNzSm1qTqgH3OGQJDfCi27sPfAA6kdJc/x26fRc6RbsofFKApnHpeUJbY/3T58oBDghdd24l35Ebg7E13Paiel4CvrGcCHJy/vH2HqBdk29xUa06bahazuLBBkSOx92b6BUtefjsGvGhoLMcNCxTUJmUM5SPK0OD+AtEU8CgYAZwL7mLQ+u3FfM+gYBOBgNgFz8vK7T6EN0sr4ERuay55WJRxCFcsFst43z+7PRy2gb0bWZEm0xfD0pF0kW+iyukXIcOBWzWNY/lnQOYzlVzmI26Ri+XI1/F03sUQgh0IpP+eZm3EwujqqxpujxmpejWJBU9MKMhpl8BxoqjiAARQKBgARMb5CTyHQeD2BKdoDnyzc8jFB8v1JGTX6+snJxSg6YWTgcalTC4hlUPtzwJlfZ9jYc87vDidUERendqpPEdbE+qcK26QMzi/r2f2aJsjCT0x49Zo1NjLBMYwXwbnpUH/RuJRsalTimGl2+tLRJNSZpGKjVeWbcSyFLiTYGWnI5AoGBAMDPQYMUO+t2H5P22d68mvjDjNbBjoyC5Dj9fPcWGDHka+sETKrxmqIdmr8+Ax6NhyGuGz2locPpXwBYvRTpa5JzD1Oj8Z41iz15t141lC2xPhdFlcigQxegLzzOeFFfaUBywhLVMCH22w527yTM9tO7Sp7I2gnW/yl5wd1AFn2y",

		//编码格式
		'charset' => "UTF-8",

		//支付宝网关
		//'gatewayUrl' => "https://openapi.alipay.com/gateway.do",
        'gatewayUrl' => "https://openapi.alipaydev.com/gateway.do",//沙箱

		//应用ID
		'app_id' => "2016073000123483",//沙箱

		//异步通知地址,只有扫码支付预下单可用    
        //mf 用户扫商家二维码异步通知地址
		'notify_url' => "",

		//最大查询重试次数
		'MaxQueryRetry' => "10",

		//查询间隔
		'QueryDuration' => "3"
);