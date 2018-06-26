<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
header("Content-type: text/html; charset=utf-8");
require_once 'f2fpay/model/builder/AlipayTradePayContentBuilder.php';
require_once 'f2fpay/service/AlipayTradeService.php';

class core_lib_alipay_barpay extends Sabstract {

    public $_alipay_config;

    function __construct() {
        $this->_alipay_config = $alipay_config = array(
            //签名方式,默认为RSA2(RSA2048)
            'sign_type' => "RSA2",
            //支付宝公钥
            'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAjcRSOwYrwmk6tXQhjp2CgWTKeNK+PEaUslrfqg/m0ijeVhp/fRZhDcd0nA2UiflBY5A98tUcxb+99yLBOOoQAqJQ/9qsZBYEDbDxL6G0G0eMbLmD7gNS6w2b9LfB0+TmsK5XJSEbidejPsg/KdAtg5zpRONiDowybyxn8shgppx9ZIYZonzIo5V4Ynqjv7e4lawF5QRg4wd/mPrTynrQAn62oz5SQJnpY89R6+GuGj5PraF5wVuK2xjMmL4M0ipDA1tGO6qUX4Pi972NcViVh3ijLExYRmMpF3gsG/QGUuoE2/8MwJjBl2xUQOgb0o+kOVLmtPMwWkZmjZzt37RxUwIDAQAB",
            //商户私钥
            //沙箱//'alipay_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA5dOw3/FnRFEuloEGV3BAGiiG3NaKWuIYdQS5eY8ewR6frzNCnTkinnlltU8oulFtm4hTert3+nPoIkulRd5OvUYYkgmayR8imUL2tvJAim3DbDFCEouEvZyAlsvlJWGH+nTuP3c4AVpFj3phddrrJfMTFurmCx5kzbTn2ptj2kFVK9M0k5A5suNSvzqWvhjCHAFdYI9FNaGjPeTTnlC7tuaqF7Ysp+EVYDiGBagt+g+LVuxN9ggeSFCk+ltyK0T+vx/vjNlaxFgp6pmEzB18riLsvkAypqJ/7cia/g1lpjgslJ+PkDHEnY+h2NWptd3trMeYwvPftswHD/d6brzPeQIDAQAB',
            'merchant_private_key' => "MIIEogIBAAKCAQEAlnu4H0LSg9NTk/2+gralF0LQltX2ntDskguFvhbfZu6bHYCvoPpTDSSM7dDzQNBpc0McV8pzaXSlGkQ2UEo2Q+nFW0zTFVi54DkuoGFwbsLgtAuOAcH6FYKbZnKUqFpLPamnDM6dunMINpVCfhYvqh4+9z7DOPp3KzzFuUzVmqHVTOqih838WC8VXre2xjVNaHXsxrsgPoq6BlcoETw2K7BpPUmrOh0jTnvULsYQ22qqrzASrmBg3XlO5fkiOFrM6Pi2AblDTj7iCze88RJDV/2ph6Q+iGofHMCmPz8lhD+sTNi+9yv0nzFq/0DVzDeGv3wmfWFBOl2R7F+DIpF6XQIDAQABAoIBABuXM3sH1XE2HezUaUmuEzbgmT4OnNkhlT5xvmPL7coBlY8jORBa1T9jpDM2TGNl0u+/LkMqa166dEsMlqjB8pEhG35R56HSUsI5ucLOGr80G97m/3JzDldDSxrNh1QWuhTkNiyy9VhqHudjFn3ns3WNdh3+8+xOf+r9iYMgA0oGegvoPJLNrKy4DhWu/G1rv713J4fNLFxh7FHXjK6YO2Aw6dgVQvff/mFykBjTvIRZfRcWOGxlBCUf3HaXp7cGDOur59SF/TlAmFwD0KUI0NiAZcvCOEnbsDQJD25fpQmsmp+9k5gdmoHOwtaAhv49J2FdL+xdwyGtUX2x1sr9GEECgYEAxQHrs1sEgNe6NMZAAvueCt4sO5dB/RBBJGeN6ly0GrIU4j3gIyEz8TVlaX0WVSHlp1sF9FAms6qR6wQKpBDzZkSHYspUWYwIn7xV7sn9I7PAGnoxWTHXlPLHjix9KHq/uj9pVo5ELI3lfu+zQcmG3OYATWIUaFBInGTrU1cth38CgYEAw4tfkCzo2rn23OTjCL8q68K6E2F7b1WGapbdCx/NxmqwG23gQ00AlUNWINJUQ5AlMgRUDqHGG21zHd1plgsomF+87PGPfFpKVia9ZwTLBxH6Gd9CZ6MveHGzexxScshbYUHBfRUGEFivBNUw6Zjt5uX/vaH/Izzn5UXvJfoCDCMCgYAa8XdN0T3dbSOPQinQ/p6Pt/DuuXIR7R4rn2n+Sm1rVT2b74Bu7YSQEZBsC+p4/CjPaZh34FpaqhJIxQW7iIHxU5/8d9VvZcJsLjLGdKOFNXkpZdrH6xQjz8xQ+m6nkZoVG8UJTG2wdjuTz66BadFi9qXF74sA9THpCbhRbpPQewKBgGvLBbf1ebsxLktghWLJ9wAVzPtoDmI2NC3H0jwSoR2SrFfCfxC6furJPs5DA55m9IoY5rlWJl3yPLYm2tCSgCNXC09WbfFv2HCbVGdYtg7EsyjV8MYup7lufDEOUMjjd7QqSl4IW9pg+MHiP99VpTdWbF790SZ8qZyyq300zzIfAoGACcu77bRUO5tc8T1INqp7zLr+uMR4k1hhhljayOTPP9S5juLE+a1BgkO6fGme0LcTswUtt/fqfb3i/jTJDvMqc2jrO98HnpLbp6UL07t/tnO0/kKjXrUxv2uMuI3zWS34b0YssV7OTTsPR2NCZXqrd//bWJSA48ARp+ote2Gta6A=",
            //编码格式
            'charset' => "UTF-8",
            //支付宝网关
            'gatewayUrl' => "https://openapi.alipay.com/gateway.do",
            //'gatewayUrl' => "https://openapi.alipaydev.com/gateway.do",//沙箱
            //应用ID
            'app_id' => "2017061607504664",
            //'app_id' => "2016080600183717",//沙箱
            //异步通知地址,只有扫码支付预下单可用
            'notify_url' => "",
            //最大查询重试次数
            'MaxQueryRetry' => "10",
            //查询间隔
            'QueryDuration' => "3"
        );
    }

    /*
     * 二维码
     */

    function pay($aData) {
        // (必填) 商户网站订单系统中唯一订单号，64个字符以内，只能包含字母、数字、下划线，
        // 需保证商户系统端不能重复，建议通过数据库sequence生成，
        $outTradeNo = $aData['out_trade_no'];
        // (必填) 订单标题，粗略描述用户的支付目的。如“XX品牌XXX门店消费”
        $subject = $aData['subject'];
        // (必填) 订单总金额，单位为元，不能超过1亿元
        // 如果同时传入了【打折金额】,【不可打折金额】,【订单总金额】三者,则必须满足如下条件:【订单总金额】=【打折金额】+【不可打折金额】
        $totalAmount = $aData['total_amount'];
        // (必填) 付款条码，用户支付宝钱包手机app点击“付款”产生的付款条码
        $authCode = $aData['auth_code']; //28开头18位数字
        // 订单描述，可以对交易或商品进行一个详细地描述，比如填写"购买商品2件共15.00元"
        $body = $aData['body'];
        ;
        //商户操作员编号，添加此参数可以为商户操作员做销售统计
        $operatorId = $aData['operator_id'];
        // (可选) 商户门店编号，通过门店号和商家后台可以配置精准到门店的折扣信息，详询支付宝技术支持
        $storeId = $aData['store_id'];
        // 支付超时，线下扫码交易定义为5分钟
        $timeExpress = "5m";

        //第三方应用授权令牌,商户授权系统商开发模式下使用
        $appAuthToken = ""; //根据真实值填写
        // 创建请求builder，设置请求参数
        $barPayRequestBuilder = new AlipayTradePayContentBuilder();
        $barPayRequestBuilder->setOutTradeNo($outTradeNo);
        $barPayRequestBuilder->setTotalAmount($totalAmount);
        $barPayRequestBuilder->setAuthCode($authCode);
        $barPayRequestBuilder->setTimeExpress($timeExpress);
        $barPayRequestBuilder->setSubject($subject);
        $barPayRequestBuilder->setBody($body);
        $barPayRequestBuilder->setStoreId($storeId);
        $barPayRequestBuilder->setOperatorId($operatorId);
        $barPayRequestBuilder->setAppAuthToken($appAuthToken);
        // 调用barPay方法获取当面付应答
        $barPay = new AlipayTradeService($this->_alipay_config);
        $barPayResult = $barPay->barPay($barPayRequestBuilder);
        
        $resultData = $barPayResult->getResponse();
        
        //保存返回记录
        $oReturn = new core_model_td_inpourreturn();
        $oReturn->set('inpour_id', $outTradeNo);
        $oReturn->set('amount', $totalAmount);
        $oReturn->set('request_format', json_encode($resultData));
        $oReturn->set('create_time', time());
        $oReturn->set('create_ymd', date('Y-m-d'));
        
        if ($barPayResult->getTradeStatus() == "SUCCESS") {
            $oReturn->set('state', 1);
            $oReturn->save();
            return $resultData->out_trade_no;
        } elseif ($barPayResult->getTradeStatus() == "FAILED") {
            $oReturn->set('error_info', '支付宝支付失败!!!！');
            $oReturn->set('state', 2);
            $oReturn->save();
            return false;
        } elseif ($barPayResult->getTradeStatus() == "UNKNOWN") {
            $oReturn->set('error_info', '系统异常，订单状态未知!!!');
            $oReturn->set('state', 2);
            $oReturn->save();
            return false;
        } else {
            $oReturn->set('error_info', '不支持的交易状态，交易返回异常!!!');
            $oReturn->set('state', 2);
            $oReturn->save();
            return false;
        }
    }

    function query($out_trade_no) {
        //第三方应用授权令牌,商户授权系统商开发模式下使用
        $appAuthToken = ""; //根据真实值填写
        //构造查询业务请求参数对象
        $queryContentBuilder = new AlipayTradeQueryContentBuilder();
        $queryContentBuilder->setOutTradeNo($out_trade_no);

        $queryContentBuilder->setAppAuthToken($appAuthToken);


        //初始化类对象，调用queryTradeResult方法获取查询应答
        $queryResponse = new AlipayTradeService($this->_alipay_config);
        $queryResult = $queryResponse->queryTradeResult($queryContentBuilder);
        $resultData = $queryResult->getResponse();
        //保存返回记录
        $oReturn = new core_model_td_inpourreturn();
        $oReturn->set('inpour_id', $resultData->out_trade_no);
        $oReturn->set('amount', $resultData->total_amount);
        $oReturn->set('request_format', json_encode($resultData));
        $oReturn->set('create_time', time());
        $oReturn->set('create_ymd', date('Y-m-d'));
        if ($queryResult->getTradeStatus() == "SUCCESS") {
            $oReturn->set('state', 1);
            $oReturn->save();
            return $resultData->trade_no;
        } elseif ($queryResult->getTradeStatus() == "FAILED") {
            $oReturn->set('error_info', '支付宝查询交易失败或者交易已关闭!!!！');
            $oReturn->set('state', 2);
            $oReturn->save();
            return false;
        } elseif ($queryResult->getTradeStatus() == "UNKNOWN") {
            $oReturn->set('error_info', '系统异常，订单状态未知!!!');
            $oReturn->set('state', 2);
            $oReturn->save();
            return false;
        } else {
            $oReturn->set('error_info', '不支持的查询状态，交易返回异常!!!');
            $oReturn->set('state', 2);
            $oReturn->save();
            return false;
        }
    }

}

?>
