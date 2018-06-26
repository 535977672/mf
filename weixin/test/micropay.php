<?php
require_once "../WxpayAPI_php_v3/lib/WxPay.Api.php";
/**
 * 
 * 刷卡支付实现类
 * 该类实现了一个刷卡支付的流程，流程如下：
 * 1、提交刷卡支付
 * 2、根据返回结果决定是否需要查询订单，如果查询之后订单还未变则需要返回查询（一般反复查10次）
 * 3、如果反复查询10订单依然不变，则发起撤销订单
 * 4、撤销订单需要循环撤销，一直撤销成功为止（注意循环次数，建议10次）
 * 
 * 该类是微信支付提供的样例程序，商户可根据自己的需求修改，或者使用lib中的api自行开发，为了防止
 * 查询时hold住后台php进程，商户查询和撤销逻辑可在前端调用
 * 
 * @author widy
 *
 */


$type = $_REQUEST["type"];
if($type==1){
    
    
    /*
     * 提交刷卡支付
     */
    //auth_code String(128) 120061098828009406 扫码支付授权码，设备读取用户微信中的条码或者二维码信息 （注：用户刷卡条形码规则：18位纯数字，以10、11、12、13、14、15开头）
    $auth_code = $_REQUEST["auth_code"];
    $totalAmount = intval($_REQUEST["totalAmount"]);
    $totalAmount = $totalAmount?$totalAmount:1;
    $input = new WxPayMicroPay();
    $input->SetAuth_code($auth_code);//授权码  条码/二维码
    $input->SetBody("TDNTTEST-服装-短袖");//商品描述
    $input->SetTotal_fee( $totalAmount );//订单金额 订单总金额，单位为分，只能为整数
    $input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis"));//商户订单号 商户系统内部订单号，要求32个字符内，只能是数字、大小写字母_-|*@ ，且在同一个商户号下唯一。

    $input->SetDevice_info('TEST1101');//设备号 device_info  String(32) 013467007045764 终端设备号(商户自定义，如门店编号) 
      $input->SetSpbill_create_ip($_SERVER['REMOTE_ADDR']);//终端ip  
    $microPay = new MicroPay();
    var_dump($microPay->pay($input));
    /*
    array(20) {
      ["appid"]=>
      string(18) "wxe4fc6d7731639e7a"
      ["attach"]=>
      array(0) {
      }
      ["bank_type"]=>
      string(3) "CFT"
      ["cash_fee"]=>
      string(1) "1"
      ["device_info"]=>
      string(8) "TEST1101"
      ["fee_type"]=>
      string(3) "CNY"
      ["is_subscribe"]=>
      string(1) "N"
      ["mch_id"]=>
      string(10) "1455290202"
      ["nonce_str"]=>
      string(16) "07xx1WwYbnWeoUY0"
      ["openid"]=>
      string(28) "oAbX5v75wGYvsmii9pY88niHONUs"
      ["out_trade_no"]=>
      string(24) "145529020220170629093740"
      ["result_code"]=>
      string(7) "SUCCESS"
      ["return_code"]=>
      string(7) "SUCCESS"
      ["return_msg"]=>
      string(2) "OK"
      ["sign"]=>
      string(32) "6A60A4BA1C3CEF519DAB32E478B5658E"
      ["time_end"]=>
      string(14) "20170629153742"
      ["total_fee"]=>
      string(1) "1"
      ["trade_state"]=>
      string(7) "SUCCESS"
      ["trade_type"]=>
      string(8) "MICROPAY"
      ["transaction_id"]=>
      string(28) "4008072001201706297977337332"
    }
     */

    
}else if($type==2){
    
    /*
     * 查询
     */
    $microPay = new MicroPay();    
    $re = $microPay->query($_REQUEST["code"], $succCode);
    var_dump($succCode);
    var_dump($re);
    //int(1) array(20) { ["appid"]=> string(18) "wxe4fc6d7731639e7a" ["attach"]=> array(0) { } ["bank_type"]=> string(3) "CFT" ["cash_fee"]=> string(1) "1" ["device_info"]=> string(8) "TEST1101" ["fee_type"]=> string(3) "CNY" ["is_subscribe"]=> string(1) "N" ["mch_id"]=> string(10) "1455290202" ["nonce_str"]=> string(16) "CPCgTc4WDx98B1M8" ["openid"]=> string(28) "oAbX5v75wGYvsmii9pY88niHONUs" ["out_trade_no"]=> string(24) "145529020220170629100608" ["result_code"]=> string(7) "SUCCESS" ["return_code"]=> string(7) "SUCCESS" ["return_msg"]=> string(2) "OK" ["sign"]=> string(32) "31C7F8A7CADEE130E78D7AA607C5B691" ["time_end"]=> string(14) "20170629160610" ["total_fee"]=> string(1) "1" ["trade_state"]=> string(7) "SUCCESS" ["trade_type"]=> string(8) "MICROPAY" ["transaction_id"]=> string(28) "4008072001201706297982400824" }
}else if($type==3){
    
    /*
     * 退款 array(2) { ["return_code"]=> string(4) "FAIL" ["return_msg"]=> string(18) "证书验证失败" }
     */
    $microPay = new MicroPay();    
    $re = $microPay->cancel($_REQUEST["code"]);
    var_dump($re);
    //mf curl错误码58
    //const SSLCERT_PATH = 'D:\bak20150523\cert\apiclient_cert.pem';
    //const SSLKEY_PATH = 'D:\bak20150523\cert\apiclient_key.pem';
    //
    //或
    //windows服务器上证书路径使用绝对路径。
    //
    //curl_setopt($ch, CURLOPT_SSLCERT, dirname(__FILE__).'cert'.DIRECTORY_SEPARATOR.'apiclient_cert.pem');
    //curl_setopt($ch, CURLOPT_SSLKEY, dirname(__FILE__).'cert'.DIRECTORY_SEPARATOR.'apiclient_key.pem');
    //curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__).'cert'.DIRECTORY_SEPARATOR.'rootca.pem');
    // Linux上使用相对路径
    //
    //curl_setopt($ch, CURLOPT_SSLCERT, 'cert'.DIRECTORY_SEPARATOR.'apiclient_cert.pem');
    //curl_setopt($ch, CURLOPT_SSLKEY, 'cert'.DIRECTORY_SEPARATOR.'apiclient_key.pem');
    //curl_setopt($ch, CURLOPT_CAINFO, 'cert'.DIRECTORY_SEPARATOR.'rootca.pem'); 
}

class MicroPay
{
	/**
	 * 
	 * 提交刷卡支付，并且确认结果，接口比较慢
	 * @param WxPayMicroPay $microPayInput
	 * @throws WxpayException
	 * @return 返回查询接口的结果
	 */
	public function pay($microPayInput)
	{
		//①、提交被扫支付
        //https://pay.weixin.qq.com/wiki/doc/api/micropay.php?chapter=9_10&index=1
		$result = WxPayApi::micropay($microPayInput, 5);        //$response = self::postXmlCurl($xml, $url, false, $timeOut);       //var_dump($result);
        //返回结果名称    变量名          必填        类型            示例值              描述 
        //返回状态码      return_code     是          String(16)      SUCCESS         SUCCESS/FAIL 此字段是通信标识，非交易标识，交易是否成功需要查看result_code来判断 
        //返回信息        return_msg      否          String(128)     签名失败        返回信息，如非空，为错误原因 签名失败 参数格式校验错误 

        //当return_code为SUCCESS的时候，还会包括以下字段： 
        //业务结果          result_code     是          String(16)      SUCCESS         SUCCESS/FAIL 
        //错误代码          err_code        否          String(32)      SYSTEMERROR     详细参见错误列表 
        //错误代码描述      err_code_des    否          String(128)     系统错误         错误返回的信息描述 
        //当return_code 和result_code都为SUCCESS的时，还会包括以下字段：
        //商户订单号        out_trade_no    是          String(32)       12177...       商户系统内部订单号，要求32个字符内，只能是数字、大小写字母_-|*@ ，且在同一个商户号下唯一。 

        /*
         * 1、 公众平台调整SSL安全策略，请开发者注意升级
         * https://mp.weixin.qq.com/cgi-bin/announce?action=getannouncement&key=1414562353&version=11&lang=zh_CN
		//curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,TRUE);
		//curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,2);//严格校验
        //mf curl错误码60
        //CURLOPT_SSL_VERIFYPEER        FALSE禁止cURL验证对等证书（peer's certificate）。要验证的交换证书可以在 CURLOPT_CAINFO 选项中设置，或在 CURLOPT_CAPATH中设置证书目录。
        //CURLOPT_SSL_VERIFYHOST        设置为 1 是检查服务器SSL证书中是否存在一个公用名(common name)。译者注：公用名(Common Name)一般来讲就是填写你将要申请SSL证书的域名 (domain)或子域名(sub domain)。 
        //                              设置成 2，会检查公用名是否存在，并且是否与提供的主机名匹配。 
        //                              0 为不检查名称。 
        //                              在生产环境中，这个值应该是 2（默认值）。
        //CURLOPT_SSLVERSION            CURL_SSLVERSION_DEFAULT (0), CURL_SSLVERSION_TLSv1 (1), CURL_SSLVERSION_SSLv2 (2), CURL_SSLVERSION_SSLv3 (3), CURL_SSLVERSION_TLSv1_0 (4), CURL_SSLVERSION_TLSv1_1 (5) ， CURL_SSLVERSION_TLSv1_2 (6) 
        //curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
		//curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);//严格校验
        //或
        if(stripos($url,"https://")!==FALSE){
            curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            }else{
            curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,TRUE);
            curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,2);//严格校验
        } 
 
         * 
         * 2、$inputObj->SetSpbill_create_ip($_SERVER['REMOTE_ADDR']);//终端ip
        //$inputObj->SetSpbill_create_ip('192.168.1.111');//mf 192.168.1.111 ["return_msg"]=> string(34) "spbill_create_ip参数格式错误"
         * 
        array(2) {
            ["return_code"]=> string(4) "FAIL"
            ["return_msg"]=> string(34) "spbill_create_ip参数格式错误" =>$inputObj->SetSpbill_create_ip('192.168.1.111');//mf 192.168.1.111 ["return_msg"]=> string(34) "spbill_create_ip参数格式错误"
          }
        
        array(20) {
            ["appid"]=>
            string(18) "wxe4fc6d7731639e7a"
            ["attach"]=>
            array(0) {
            }
            ["bank_type"]=>
            string(3) "CFT"
            ["cash_fee"]=>
            string(1) "1"
            ["cash_fee_type"]=>
            string(3) "CNY"
            ["device_info"]=>
            string(8) "TEST1101"
            ["fee_type"]=>
            string(3) "CNY"
            ["is_subscribe"]=>
            string(1) "N"
            ["mch_id"]=>
            string(10) "1455290202"
            ["nonce_str"]=>
            string(32) "ohgg4ahrvpj7y388f0l4xz5qxeaijta5"
            ["openid"]=>
            string(28) "oAbX5v75wGYvsmii9pY88niHONUs"
            ["out_trade_no"]=>
            string(24) "145529020220170629093740"
            ["result_code"]=>
            string(7) "SUCCESS"
            ["return_code"]=>
            string(7) "SUCCESS"
            ["return_msg"]=>
            string(2) "OK"
            ["sign"]=>
            string(32) "25E8F55512AC8F1C4008A3BECA5395E6"
            ["time_end"]=>
            string(14) "20170629153742"
            ["total_fee"]=>
            string(1) "1"
            ["trade_type"]=>
            string(8) "MICROPAY"
            ["transaction_id"]=>
            string(28) "4008072001201706297977337332"
          }
        
         */
        
		//如果返回成功
		if(!array_key_exists("return_code", $result)
			|| !array_key_exists("out_trade_no", $result)
			|| !array_key_exists("result_code", $result))
		{
			echo "接口调用失败,请确认是否输入是否有误！";
			throw new WxPayException("接口调用失败！");
            //Fatal error: Uncaught exception 'WxPayException' with message '接口调用失败！' in D:\bak20150523\tdntmf-test\app\test99\weixin\test\micropay.php:33 Stack trace: #0 {main} thrown in D:\bak20150523\tdntmf-test\app\test99\weixin\test\micropay.php on line 33
		}
		
		//签名验证
		$out_trade_no = $microPayInput->GetOut_trade_no();
		
		//②、接口调用成功，明确返回调用失败
		if($result["return_code"] == "SUCCESS" &&
		   $result["result_code"] == "FAIL" && 
		   $result["err_code"] != "USERPAYING" && //USERPAYING 用户支付中，需要输入密码 支付结果未知 该笔交易因为业务规则要求，需要用户输入支付密码。 等待5秒，然后调用被扫订单结果查询API，查询当前订单的不同状态，决定下一步的操作。 
		   $result["err_code"] != "SYSTEMERROR")//SYSTEMERROR 接口返回错误 支付结果未知 系统超时 请立即调用被扫订单结果查询API，查询当前订单状态，并根据订单的状态决定下一步的操作。 
		{
            //echo $result["err_code_des"];
			return false;
		}

		//③、确认支付是否成功
		$queryTimes = 10;
		while($queryTimes > 0)
		{
			$succResult = 0;
            //查询订单情况
			$queryResult = $this->query($out_trade_no, $succResult);
			//如果需要等待1s后继续
			if($succResult == 2){
				sleep(2);
				continue;
			} else if($succResult == 1){//查询成功
				return $queryResult;
			} else {//订单交易失败
				return false;
			}
		}
		
		//④、次确认失败，则撤销订单
        //撤销订单，如果失败会重复调用10次
		if(!$this->cancel($out_trade_no))
		{
			throw new WxpayException("撤销单失败！");
		}

		return false;
	}
	
	/**
	 * 
	 * 查询订单情况
	 * @param string $out_trade_no  商户订单号
	 * @param int $succCode         查询订单结果
	 * @return 0 订单不成功，1表示订单成功，2表示继续等待
	 */
	public function query($out_trade_no, &$succCode)
	{
		$queryOrderInput = new WxPayOrderQuery();
		$queryOrderInput->SetOut_trade_no($out_trade_no);
        //https://pay.weixin.qq.com/wiki/doc/api/micropay.php?chapter=9_2  该接口提供所有微信支付订单的查询，商户可以通过查询订单接口主动查询订单状态，完成下一步的业务逻辑。
		$result = WxPayApi::orderQuery($queryOrderInput);       //$response = self::postXmlCurl($xml, $url, false, $timeOut);         //var_dump($result);
        //返回结果名称    变量名          必填        类型            示例值              描述 
        //返回状态码      return_code     是          String(16)      SUCCESS         SUCCESS/FAIL 此字段是通信标识，非交易标识，交易是否成功需要查看result_code来判断 
        //返回信息        return_msg      否          String(128)     签名失败        返回信息，如非空，为错误原因 签名失败 参数格式校验错误 

        //当return_code为SUCCESS的时候，还会包括以下字段： 
        //业务结果          result_code     是          String(16)      SUCCESS         SUCCESS/FAIL 
        //错误代码          err_code        否          String(32)      SYSTEMERROR     详细参见错误列表 ORDERNOTEXIST  此交易订单号不存在 SYSTEMERROR  系统错误   
        //错误代码描述      err_code_des    否          String(128)     系统错误         错误返回的信息描述 
        
        //以下字段在return_code 、result_code、trade_state都为SUCCESS时有返回 ，如trade_state不为 SUCCESS，则只返回out_trade_no（必传）和attach（选传）。
        //商户订单号        out_trade_no    是          String(32)       12177...       商户系统内部订单号，要求32个字符内，只能是数字、大小写字母_-|*@ ，且在同一个商户号下唯一。 
		//附加数据          attach          否          String(128)     深圳分店        附加数据，原样返回  
        //交易状态          trade_state     是          String(32)      SUCCESS         SUCCESS—支付成功 REFUND—转入退款 NOTPAY—未支付 CLOSED—已关闭 REVOKED—已撤销（刷卡支付） USERPAYING--用户支付中 PAYERROR--支付失败(其他原因，如银行返回失败)
        /*
        array(20) {
            ["appid"]=>
            string(18) "wxe4fc6d7731639e7a"
            ["attach"]=>
            array(0) {
            }
            ["bank_type"]=>
            string(3) "CFT"
            ["cash_fee"]=>
            string(1) "1"
            ["device_info"]=>
            string(8) "TEST1101"
            ["fee_type"]=>
            string(3) "CNY"
            ["is_subscribe"]=>
            string(1) "N"
            ["mch_id"]=>
            string(10) "1455290202"
            ["nonce_str"]=>
            string(16) "07xx1WwYbnWeoUY0"
            ["openid"]=>
            string(28) "oAbX5v75wGYvsmii9pY88niHONUs"
            ["out_trade_no"]=>
            string(24) "145529020220170629093740"
            ["result_code"]=>
            string(7) "SUCCESS"
            ["return_code"]=>
            string(7) "SUCCESS"
            ["return_msg"]=>
            string(2) "OK"
            ["sign"]=>
            string(32) "6A60A4BA1C3CEF519DAB32E478B5658E"
            ["time_end"]=>
            string(14) "20170629153742"
            ["total_fee"]=>
            string(1) "1"
            ["trade_state"]=>
            string(7) "SUCCESS"
            ["trade_type"]=>
            string(8) "MICROPAY"
            ["transaction_id"]=>
            string(28) "4008072001201706297977337332"
          }
         */
        
        
		if($result["return_code"] == "SUCCESS" 
			&& $result["result_code"] == "SUCCESS")
		{
			//支付成功
			if($result["trade_state"] == "SUCCESS"){
				$succCode = 1;
			   	return $result;
			}
			//用户支付中
			else if($result["trade_state"] == "USERPAYING"){
				$succCode = 2;
				return false;
			}
		}
		
		//如果返回错误码为“此交易订单号不存在”则直接认定失败
		if($result["err_code"] == "ORDERNOTEXIST")
		{
			$succCode = 0;
		} else{
			//如果是系统错误，则后续继续
			$succCode = 2;
		}
		return false;
	}
	
	/**
	 * 
	 * 撤销订单，如果失败会重复调用10次
	 * @param string $out_trade_no
	 * @param 调用深度 $depth
	 */
	public function cancel($out_trade_no, $depth = 0)
	{
		if($depth > 10){
			return false;
		}
		
		$clostOrder = new WxPayReverse();
		$clostOrder->SetOut_trade_no($out_trade_no);
        //https://pay.weixin.qq.com/wiki/doc/api/micropay.php?chapter=9_11&index=3
        //支付交易返回失败或支付系统超时，调用该接口撤销交易。如果此订单用户支付失败，微信支付系统会将此订单关闭；如果用户支付成功，微信支付系统会将此订单资金退还给用户。
        //注意：7天以内的交易单可调用撤销，其他正常支付的单如需实现相同功能请调用申请退款API。提交支付交易后调用【查询订单API】，没有明确的支付结果再调用【撤销订单API】。
        //调用支付接口后请勿立即调用撤销订单API，建议支付后至少15s后再调用撤销订单接口。 
		$result = WxPayApi::reverse($clostOrder); //$response = self::postXmlCurl($xml, $url, true, $timeOut);
        //var_dump($result);//array(2) { ["return_code"]=> string(4) "FAIL" ["return_msg"]=> string(18) "证书验证失败" }
        //返回结果名称    变量名          必填        类型            示例值              描述 
        //返回状态码      return_code     是          String(16)      SUCCESS         SUCCESS/FAIL 此字段是通信标识，非交易标识，交易是否成功需要查看result_code来判断 
        //返回信息        return_msg      否          String(128)     签名失败        返回信息，如非空，为错误原因 签名失败 参数格式校验错误 

        //当return_code为SUCCESS的时候，还会包括以下字段： 
        //业务结果          result_code     是          String(16)      SUCCESS         SUCCESS/FAIL 
        //错误代码          err_code        否          String(32)      SYSTEMERROR     详细参见错误列表 ORDERNOTEXIST  此交易订单号不存在 SYSTEMERROR  系统错误   
        //错误代码描述      err_code_des    否          String(128)     系统错误         错误返回的信息描述 
        
        //是否重调          recall          是          String(1)       Y               是否需要继续调用撤销，Y-需要，N-不需要 
        
        
		//接口调用失败
		if($result["return_code"] != "SUCCESS"){
			return false;
		}
		
		//如果结果为success且不需要重新调用撤销，则表示撤销成功
		if($result["result_code"] != "SUCCESS" 
			&& $result["recall"] == "N"){//是否重调   
			return true;
		} else if($result["recall"] == "Y") {
			return $this->cancel($out_trade_no, ++$depth);
		}
		return false;
	}
}