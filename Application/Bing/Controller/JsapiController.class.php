<?php
namespace Bing\Controller;
use Think\Controller;
class JsapiController extends Controller {
    public function index(){
        ini_set('date.timezone','Asia/Shanghai');
        Vendor('weixin.WxPayApi');
        Vendor('weixin.JsApiPay');

        //①、获取用户openid
        $tools = new \JsApiPay();
        $openId = $tools->GetOpenid();
        if(isset($openId)){
            cookie("openId",$openId);
        }else{
            $openId=cookie("openId");
        }

        //②、统一下单
        $input = new \WxPayUnifiedOrder();
        $input->SetBody("test");
        $input->SetAttach("test");
        $input->SetOut_trade_no(\WxPayConfig::MCHID.date("YmdHis"));
        $input->SetTotal_fee("1");
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag("test");
        $input->SetNotify_url("http://".$_SERVER['HTTP_HOST']."/index.php/Bing/Jsapi//notify");
        $input->SetTrade_type("JSAPI");
        $input->SetOpenid($openId);
        $order = \WxPayApi::unifiedOrder($input);
        $jsApiParameters = $tools->GetJsApiParameters($order);
        $this->assign("jsApiParameters",$jsApiParameters);
        $this->display("Jsapi/index");
    }


    /**
     * 支付后回调处理
     * @param $data
     * @param $msg
     * @return bool
     */
    public function notify($data,$msg){
        if(!array_key_exists("transaction_id", $data)){
            $msg = "输入参数不正确";
            return false;
        }else{
            //查询订单，判断订单真实性
            $this->Queryorder($data["transaction_id"]);
        }
    }


    /**
     * 订单查询
     * @param $transaction_id
     * @return bool
     */
    public function Queryorder($transaction_id)
    {
        ini_set('date.timezone','Asia/Shanghai');
        Vendor('weixin.WxPayApi');
        Vendor('weixin.WxPayNotify');
        $input = new \WxPayOrderQuery();
        $input->SetTransaction_id($transaction_id);
        $result = \WxPayApi::orderQuery($input);
        if(array_key_exists("return_code", $result)
            && array_key_exists("result_code", $result)
            && $result["return_code"] == "SUCCESS"
            && $result["result_code"] == "SUCCESS")
        {
            //如果订单存在则处理相关业务逻辑

        }else{
            //如果订单不存在则处理相关业务逻辑
        }
    }
}