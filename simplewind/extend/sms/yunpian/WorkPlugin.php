<?php
namespace sms\yunpian;

// use express\kuaidi100\custom\Express;
// import('sms/yunpian/custom/coreFunc',EXTEND_PATH);

/**
 * 快递接口
 */
class WorkPlugin
{
    public $plugin_id = 'yunpian'; // 插件唯一ID

    /**
     * +----------------------------------------------------------
     * 构造函数
     * +----------------------------------------------------------
     */
    public function __construct()
    {
        $this->config = $this->p_set();
    }

    /**
     * [work description]
     * @param  [type] $mobile [对象手机号]
     * @return [type]         [description]
     */
    public function work($mobile)
    {
        // 建立请求
        $code = rand(1000, 9999);
        // $_SESSION['sms_code'] = $code;
        session('sms_code', $code);

        require_once dirname(__FILE__) . '/YunpianAutoload.php';
        // require_once 'YunpianAutoload.php';

        // 发送单条短信
        $smsOperator    = new SmsOperator();
        $data['mobile'] = trim($mobile); //发送对象手机号
        // $text = $this->config['sign']."您的验证码是". $code ."。如非本人操作，请忽略本短信";
        $data['text'] = $this->config['sign'] . '您的验证码是' . $code;
        $result       = $smsOperator->single_send($data);

        $result = (array) $result;
        if ($result['success']) {
            return true;
        } else {
            return false;
        }

        // var_dump($result);die;
    }

    /*配置信息*/
    public function p_set()
    {
        $set = cmf_get_option('sms_yunpian');

        // 短信账号
        $pset['account'] = $set['account'];

        // 签名
        $pset['sign'] = $set['sign'];

        // 安全检验码，以数字和字母组成的32位字符
        $pset['apikey'] = $set['apikey'];

        // 重发间隔，纯数字
        $pset['retry_times'] = $set['retry_times'];

        // 字符编码
        $pset['charset'] = $set['charset'];

        return $pset;
    }

    /*请求参数*/
    public function parameter()
    {
        $set = $this->p_set();

        // 字符编码格式 目前支持 gbk 或 utf-8
        $param['_input_charset'] = trim(strtolower(strtolower('utf-8')));

        return $param;
    }

    /*
     * 更多测试资料
     */
    public function more()
    {

        /*// 原始数据
    // 成功
    object(Result)#26 (5) {
    ["success"]=>
    bool(true)
    ["statusCode"]=>
    int(200)
    ["requestData"]=>
    array(3) {
    ["mobile"]=>
    string(11) "18715511536"
    ["text"]=>
    string(49) "【微步大数据营销】您的验证码是3436"
    ["apikey"]=>
    string(32) "96984feab7ee7412c616fbe854245dbd"
    }
    ["responseData"]=>
    array(7) {
    ["code"]=>
    int(0)
    ["msg"]=>
    string(12) "发送成功"
    ["count"]=>
    int(1)
    ["fee"]=>
    float(0.05)
    ["unit"]=>
    string(3) "RMB"
    ["mobile"]=>
    string(11) "18715511536"
    ["sid"]=>
    float(17550673356)
    }
    ["error"]=>
    NULL
    }

    // 失败
    object(Result)#26 (5) {
    ["success"]=>
    bool(false)
    ["statusCode"]=>
    int(400)
    ["requestData"]=>
    array(3) {
    ["mobile"]=>
    string(11) "18715511536"
    ["text"]=>
    string(49) "【微步大数据营销】您的验证码是5450"
    ["apikey"]=>
    string(32) "96984feab7ee7412c616fbe854245dbd"
    }
    ["responseData"]=>
    array(4) {
    ["http_status_code"]=>
    int(400)
    ["code"]=>
    int(22)
    ["msg"]=>
    string(71) "验证码类短信1小时内同一手机号发送次数不能超过3次"
    ["detail"]=>
    string(71) "验证码类短信1小时内同一手机号发送次数不能超过3次"
    }
    ["error"]=>
    NULL
    }
     */
    }
}
