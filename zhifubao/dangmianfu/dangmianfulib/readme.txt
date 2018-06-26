一、免责申明：
此DEMO仅供参考，实际开发中需要结合具体业务场景修改使用。




二、扫码支付中，如果商户通过异步通知来判断支付结果：需要严格按照如下描述校验通知数据的正确性。
	
	1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号，
	
	2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额），	
	3、校验通知中的seller_id（或者seller_email)是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email），
	
	4、验证app_id是否为调用方的appid。

三、demo的运行环境：适用于php5.5以上的开发环境


img 下测试图片


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
