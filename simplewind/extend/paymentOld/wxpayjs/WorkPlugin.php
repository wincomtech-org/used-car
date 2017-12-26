<?php
// namespace paymentOld\wxpayjs;

use paymentOld\wxpayjs\lib\JsApiPay;
use paymentOld\common\wxpay\lib\WxPayApi;
use paymentOld\common\wxpay\lib\WxPayException;
use paymentOld\common\wxpay\lib\WxPayConfig;
// use paymentOld\common\wxpay\lib\WxPayData;//WxPayData不是类，只是文件名
use paymentOld\common\wxpay\lib\WxPayUnifiedOrder;

// import('paymentOld/common/wxpay/coreFunc',EXTEND_PATH);

/**
* 微信支付接口
* 用到 WxPayConfig.php 配置的文件： WxPayApi.php  JsApiPay.php  WxPayData.php
*/
class WorkPlugin
{
    var $plugin_id = 'wxpayjs';// 插件唯一ID
    private $p_set = [];
    private $notify_url = '';
    private $return_url = '';
    private $dir = '';// getcwd()
    private $host = '';

    function __construct($order_sn='', $order_amount='', $order_id='123', $action='')
    {
        $this->order_sn = $order_sn;
        $this->order_amount = intval(ceil($order_amount*100));
        // $this->order_id = $order_id;
        $this->action = $action;
        $this->host = cmf_get_domain();
        $this->notify_url = url('funds/Pay/wxpayBack','',false,$this->host);
        $this->return_url = url('funds/Pay/wxpayBack','',false,$this->host);

        // TP写法 
        import('paymentOld/common/wxpay/coreFunc',EXTEND_PATH);
    }

    /**
     * +----------------------------------------------------------
     * 建立支付请求
     * +----------------------------------------------------------
    */
    // 默认
    public function work($auto=true,$jumpurl='')
    {
        $result = $this->workJsApi($jumpurl);
        return $result;
    }

    // JSAPI支付
    public function workJsApi($jumpurl) {
        // $payApi = new WxPayApi();
        // $order = $payApi->unifiedOrder($this->parameter());
        $order = WxPayApi::unifiedOrder($this->parameter());

        //echo '<font color="#f00"><b>统一下单支付单信息：</b></font><br/>';
        // printf_info($order);exit;

        $tools = new JsApiPay();
        $jsApiParameters = $tools->GetJsApiParameters($order);

        //获取共享收货地址js函数参数
        // $editAddress = $tools->GetEditAddressParameters();

        $jumpurl = [
            'ok'    => url('funds/Pay/wxpayBack',$this->getReturn(),false,$this->host),
            'cancel'=> $jumpurl,
            'fail'  => $jumpurl,
        ];

        return $this->jsApi($jsApiParameters,$jumpurl);
    }

    // 获取用户openid
    public function getOpenid()
    {
        $tools = new JsApiPay();//sdk中有这个类
        $openid = $tools->GetOpenid();// 多次CURL后只能用cookie获取其它参数
        // session('openid',$openid);

        return $openid;
    }

    // 调起 JS api
    public function jsApi($jsApiParameters='',$jumpurl)
    {
        $html = <<<EOF
        <script type="text/javascript">
            //调用微信JS api 支付
            function jsApiCall()
            {
                WeixinJSBridge.invoke(
                    'getBrandWCPayRequest',$jsApiParameters,
                    function(res){
                        // WeixinJSBridge.log(res.err_msg);
                        // alert(res.err_code+res.err_desc+res.err_msg);
                        switch (res.err_msg){
                            //取消支付 
                            case 'get_brand_wcpay_request:cancel':
                                alert('您已取消，请耐心等待跳转');
                                location.href='{$jumpurl[cancel]}';
                                break;
                            //支付失败
                            case 'get_brand_wcpay_request:fail':
                                alert(res.err_desc);
                                window.history.back(-1);
                                //location.href='{$jumpurl[fail]}';
                                break;
                            //支付成功
                            case 'get_brand_wcpay_request:ok':
                                alert('您已支付成功，请耐心等待跳转');
                                location.href='{$jumpurl[ok]}';
                                break;
                        }
                    }
                );
            }

            function callpay()
            {
                if (typeof WeixinJSBridge=='undefined'){
                    if( document.addEventListener ){
                        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
                    }else if (document.attachEvent){
                        document.attachEvent('WeixinJSBridgeReady', jsApiCall);
                        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
                    }
                }else{
                    jsApiCall();
                }
            }
            callpay();
        </script>
EOF;
        return $html;
    }




    /*
    * 功能：同步通知页面
    */
    public function getReturn()
    {
        // 在这里只管返回数据

        $data = [
            // 'paytype'   => 'wxpay',
            'action'    => $this->action,//可根据订单号来获取
            'coin'      => $this->order_amount,
            'out_trade_no' => $this->order_sn,
            // 'id'        => $this->order_id,
        ];

        return $data;
    }

    /*
    * 功能：异步通知页面
    */
    public function getNotify()
    {
        // paylog();
        return false;
    }

    /**
     * 服务器点对点响应操作给支付接口方调用
     * 
     */
    // function response()
    // {
    //     require_once("wxpay/example/notify.php");
    //     $notify = new PayNotifyCallBack();
    //     $notify->Handle(false);
    // }




    /*
    * 功能：订单查询
    */
    public function orderStatus($value='')
    {
        // 获取插件配置信息
        $set = $this->p_set();

        //查询订单
        $inputObj = new WxPayOrderQuery($set);// WxPayDataBase($set);
        $inputObj->SetOut_trade_no($this->order_sn);

        // $result = WxPayApi::orderQuery($inputObj);
        $payApi = new WxPayApi($set);
        $result = $payApi->orderQuery($inputObj);

        // Log::DEBUG("query:" . json_encode($result));

        if ( array_key_exists('return_code',$result) && 
            $result['return_code']=='SUCCESS' && 
            array_key_exists('result_code',$result) && 
            $result['result_code']=='SUCCESS' && 
            $result['trade_state']=='SUCCESS' )
        {
            return true;
            // $result['wxpay_status'] = true;
        } else {
            return false;
            // $result['wxpay_status'] = false;
        }
        // return $result;
    }

    /*退款*/
    public function refund($value='')
    {
        # code...
    }
    public function refundStatus($value='')
    {
        # code...
    }



    /**
     * +----------------------------------------------------------
     * 配置信息
     * +----------------------------------------------------------
    */
    public function p_set() {
        // 获取插件配置信息
        // {"appid":"","mchid":"","key":"","switch":"0","appsecret":""}
        // $option = cmf_get_option('alipay_settings');

        //↓↓↓↓↓↓↓↓↓↓请在这里配置您的基本信息↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓

        // 将官版的常量改为静态变量
        // APPID：绑定支付的APPID（必须配置，开户邮件中可查看）
        // WxPayConfig::$appid = $option['appid'];
        // MCHID：商户号（必须配置，开户邮件中可查看）
        // WxPayConfig::$mchid = $option['mchid'];
        // KEY：商户支付密钥，参考开户邮件设置（必须配置，登录商户平台自行设置）
        // WxPayConfig::$key = $option['key'];
        // 公众帐号secert（仅JSAPI支付的时候需要配置）
        // WxPayConfig::$appsecret = $option['appsecret'];
        // echo WxPayConfig::$appsecret;die;

        //↑↑↑↑↑↑↑↑↑↑请在这里配置您的基本信息↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑

        // $set = [];
        // return $set;
    }

    /**
     * +----------------------------------------------------------
     * 请求参数 统一下单
     * +----------------------------------------------------------
     */
    public function parameter() {
        // $set = $this->p_set();
        $siteInfo = cmf_get_option('site_info');

        $input = new WxPayUnifiedOrder();
        // 商品描述。编码问题，不能为中文？
        $input->SetBody('OrderSn：'. $this->order_sn .' ('. $siteInfo['site_name'] .')');

        // 附加数据。编码问题，不能为中文。非必填
        $input->SetAttach("add");

        // 商户订单号，编码问题，只能是字母、数字
        $input->SetOut_trade_no($this->order_sn);
        // 总金额，单位：分。不能为小数
        $input->SetTotal_fee($this->order_amount);

        // 订单生成时间。非必填
        $input->SetTime_start(date("YmdHis"));
        // 订单失效时间。非必填
        $input->SetTime_expire(date("YmdHis",time()+600));

        // 商品标记，代金券或立减优惠功能的参数。
        $input->SetGoods_tag("voucher");

        // 异步通知回调地址。
        // $input->SetNotify_url("http://paysdk.weixin.qq.com/example/notify.php");
        $input->SetNotify_url($this->notify_url);

        // 支付方式
        $input->SetTrade_type("JSAPI");
        // 用户openid
        $input->SetOpenid($this->getOpenid());

        /*--扩展功能参数--*/

        return $input;
    }


}