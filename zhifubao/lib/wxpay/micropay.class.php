<?php

require_once "lib/WxPay.Api.php";

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
class core_lib_wxpay_micropay extends Sabstract {

    /**
     * 
     * 提交刷卡支付，并且确认结果，接口比较慢
     * @param WxPayMicroPay $microPayInput
     * @throws WxpayException
     * @return 返回查询接口的结果
     */
    public function pay($data) {
        $body = $data['body'];
        $device_info = $data['device_info'];
        $out_trade_no = $data['out_trade_no'];
        $auth_code = $data['auth_code'];
        $total_fee = $data['money'] * 100;

        $microPayInput = new WxPayMicroPay();

        $microPayInput->SetBody($body);
        $microPayInput->SetOut_trade_no($out_trade_no);
        $microPayInput->SetTotal_fee($total_fee);
        $microPayInput->SetAuth_code($auth_code);
        $microPayInput->SetDevice_info($device_info);

        //①、提交被扫支付
        $result = WxPayApi::micropay($microPayInput, 5);

        //保存返回记录
        $oReturn = new core_model_td_inpourreturn();
        $oReturn->set('inpour_id', $out_trade_no);
        $oReturn->set('amount', $total_fee / 100);
        $oReturn->set('request_format', json_encode($result));
        $oReturn->set('create_time', time());
        $oReturn->set('create_ymd', date('Y-m-d'));

        //如果返回成功
        if (!array_key_exists("return_code", $result) || !array_key_exists("return_msg", $result)) {
            //echo "接口调用失败,请确认是否输入是否有误！";
            //throw new WxPayException("接口调用失败！");
            $oReturn->set('error_info', '接口调用失败,请确认是否输入是否有误！');
            $oReturn->set('state', 2);
            $oReturn->save();
            return false;
        }
        $out_trade_no = $microPayInput->GetOut_trade_no();

        $inpour_mdl = new core_model_td_inpour($out_trade_no);
        $inpour_data = $inpour_mdl->getData();
        if (!$inpour_data) {
            $oReturn->set('error_info', '商户订单号有误');
            $oReturn->set('state', 2);
            $oReturn->save();
            return false;
        }

        //②、接口调用成功，明确返回调用失败
        if ($result["return_code"] == "SUCCESS" && $result["result_code"] == "FAIL" && $result["err_code"] != "USERPAYING" && $result["err_code"] != "SYSTEMERROR") {
            $oReturn->set('error_info', $result["err_code_des"]);
            $oReturn->set('state', 2);
            $oReturn->save();
            return false;
        } else {
            $oReturn->set('state', 1);
            $oReturn->save();
            return $out_trade_no;
        }
    }

    /**
     * 
     * 查询订单情况
     * @param string $out_trade_no  商户订单号
     * @param int $succCode         查询订单结果
     * @return 0 订单不成功，1表示订单成功，2表示继续等待
     */
    public function query($out_trade_no, &$succCode) {
        $queryOrderInput = new WxPayOrderQuery();
        $queryOrderInput->SetOut_trade_no($out_trade_no);
        $result = WxPayApi::orderQuery($queryOrderInput);

        if ($result["return_code"] == "SUCCESS"
                && $result["result_code"] == "SUCCESS") {
            //支付成功
            if ($result["trade_state"] == "SUCCESS") {
                $succCode = 1;
                return $result;
            }
            //用户支付中
            else if ($result["trade_state"] == "USERPAYING") {
                $succCode = 2;
                return false;
            }
        }

        //如果返回错误码为“此交易订单号不存在”则直接认定失败
        if ($result["err_code"] == "ORDERNOTEXIST") {
            $succCode = 0;
        } else {
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
    public function cancel($out_trade_no, $depth = 0) {
        if ($depth > 10) {
            return false;
        }

        $clostOrder = new WxPayReverse();
        $clostOrder->SetOut_trade_no($out_trade_no);
        $result = WxPayApi::reverse($clostOrder);

        //接口调用失败
        if ($result["return_code"] != "SUCCESS") {
            return false;
        }

        //如果结果为success且不需要重新调用撤销，则表示撤销成功
        if ($result["result_code"] != "SUCCESS"
                && $result["recall"] == "N") {
            return true;
        } else if ($result["recall"] == "Y") {
            return $this->cancel($out_trade_no, ++$depth);
        }
        return false;
    }

}