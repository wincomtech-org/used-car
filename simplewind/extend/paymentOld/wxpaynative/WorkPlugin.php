<?php
// namespace paymentOld\wxpaynative;

// use paymentOld\wxpaynative\lib\coreFunc;//不是类
use paymentOld\wxpaynative\lib\NativePay;
use paymentOld\common\wxpay\lib\WxPayApi;
use paymentOld\common\wxpay\lib\WxPayException;
// use paymentOld\common\wxpay\lib\WxPayConfig;//已改
// use paymentOld\common\wxpay\lib\WxPayData;//WxPayData不是类，只是文件名
use paymentOld\common\wxpay\lib\WxPayUnifiedOrder;

// import('paymentOld/common/wxpay/coreFunc',EXTEND_PATH);
import('paymentOld/wxpaynative/lib/WxPayData',EXTEND_PATH);

/**
* 微信支付接口
* 用到 WxPayConfig.php 配置的文件： WxPayApi.php  JsApiPay.php  WxPayData.php
*/
class WorkPlugin
{
    var $plugin_id = 'wxpaynative';// 插件唯一ID
    private $p_set = [];
    private $notify_url = '';
    private $return_url = '';
    private $dir = '';// getcwd()
    private $host = '';

    function __construct($order_sn='', $order_amount='', $order_id='123', $action='')
    {
        $this->order_sn = $order_sn;
        $this->order_amount = intval(ceil($order_amount*100));
        $this->order_id = $order_id;
        // $this->action = $action;
        $this->host = cmf_get_domain();
        // $this->notify_url = url('funds/Pay/callBack','',false,$this->host);
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
        $result = $this->workUrl();
        return $result;
    }

    // 模式一 回调
    public function workPreUrl() {
        $notify = new NativePay();
        $pay_url = $notify->GetPrePayUrl($this->order_id);
        return $pay_url;
    }

    // 模式二
    public function workUrl()
    {
        $input  = $this->parameter();
        $notify = new NativePay();
        $result = $notify->GetPayUrl($input);
        // dump($result);die;
        $pay_url   = $result["code_url"];

        $pay_url = QRcodeByUrl($pay_url);

        return $pay_url;
    }

    // 二维码
    public function QRcode($pay_url='')
    {
        if (empty($pay_url)) {
            QRcodeByUrl($pay_url);
        } else {
            return '<img alt="模式二扫码支付" src="/index.php?m=Home&c=Index&a=qr_code&data='.urlencode($pay_url).'" style="width:110px;height:110px;"/>';  
        }
    }



    /*
    * 功能：页面跳转同步通知页面
    */
    public function getReturn()
    {
        // paylog();
        return false;
    }

    /*
    * 功能：服务器异步通知页面
    */
    public function getNotify()
    {
        // paylog();
        return false;
    }




    /*
    * 功能：订单查询
    */
    public function orderStatus()
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
        $option = cmf_get_option('weixin_settings');

        //↓↓↓↓↓↓↓↓↓↓请在这里配置您的基本信息↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
        $set['APPID'] = $option['appid'];
        $set['APPSECRET'] = $option['appsecret'];
        $set['MCHID'] = $option['mchid'];
        $set['KEY'] = $option['key'];

        //↑↑↑↑↑↑↑↑↑↑请在这里配置您的基本信息↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑

        // 异步通知url未设置，则使用配置文件中的url
        $set['NOTIFY_URL'] = $this->notify_url;
        
        //=======【证书路径设置】=====================================
        /**
         * TODO：设置商户证书路径
         * 证书路径,注意应该填写绝对路径（仅退款、撤销订单时需要，可登录商户平台下载，API证书下载地址：https://pay.weixin.qq.com/index.php/account/api_cert，下载之前需要安装商户操作证书）
         * @var path
            const SSLCERT_PATH = '../apiclient_cert.pem';
            const SSLKEY_PATH = '../apiclient_key.pem';
        */
        $set['SSLCERT_PATH'] = EXTEND_PATH .'paymentOld/'. $this->plugin_id .'/apiclient_cert.pem';
        $set['SSLKEY_PATH'] = EXTEND_PATH .'paymentOld/'. $this->plugin_id .'/apiclient_key.pem';

        //=======【curl代理设置】===================================
        /**
         * TODO：这里设置代理机器，只有需要代理的时候才设置，不需要代理，请设置为0.0.0.0和0
         * 本例程通过curl使用HTTP POST方法，此处可修改代理服务器，
         * 默认CURL_PROXY_HOST=0.0.0.0和CURL_PROXY_PORT=0，此时不开启代理（如有需要才设置）
         * @var unknown_type
            const CURL_PROXY_HOST = "0.0.0.0";//"10.152.18.220";
            const CURL_PROXY_PORT = 0;//8080;
        */
        $set['CURL_PROXY_HOST'] = '0.0.0.0';
        $set['CURL_PROXY_PORT'] = 0;

        //=======【上报信息配置】===================================
        /**
         * TODO：接口调用上报等级，默认紧错误上报（注意：上报超时间为【1s】，上报无论成败【永不抛出异常】，
         * 不会影响接口调用流程），开启上报之后，方便微信监控请求调用的质量，建议至少
         * 开启错误上报。
         * 上报等级，0.关闭上报; 1.仅错误出错上报; 2.全量上报
         * @var int
            const REPORT_LEVENL = 1;
        */
        $set['REPORT_LEVENL'] = 1;
        
        return $set;
    }

    /**
     * +----------------------------------------------------------
     * 请求参数
     * +----------------------------------------------------------
     */
    public function parameter() {
        // $set = $this->p_set();
        $siteInfo = cmf_get_option('site_info');

        $input = new WxPayUnifiedOrder();
        // 商品描述。编码问题，不能为中文
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
        $input->SetTrade_type("NATIVE");
        // 商品ID
        $input->SetProduct_id($this->order_id);

        /*--扩展功能参数--*/

        return $input;
    }



}