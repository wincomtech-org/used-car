<?php
namespace paymentOld\alipay\lib;
/**
 * 类名：AlipaySubmit
 * 功能：支付宝各接口请求提交类
 * 详细：构造支付宝各接口表单HTML文本，获取远程HTTP数据
 * 版本：3.3
 * 日期：2012-07-23
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。
 */
// require_once "coreFunc.php";

class AlipaySubmit
{
    public $p_set;
    // 支付宝网关地址（新）
    public $alipay_gateway_new = 'https://mapi.alipay.com/gateway.do?';

    public function __construct($p_set)
    {
        $this->p_set = $p_set;
    }

    /**
     * 生成签名结果
     * @param $para_sort 已排序要签名的数组
     * return 签名结果字符串
     */
    public function buildRequestMysign($para_sort)
    {
        //把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
        $prestr = createLinkstring($para_sort);
        $mysign = "";
        switch (strtoupper(trim($this->p_set['sign_type']))) {
            case "MD5":
                $mysign = md5Sign($prestr, $this->p_set['key']);
                break;
            default:
                $mysign = "";
        }
        return $mysign;
    }

    /**
     * 生成要请求给支付宝的参数数组
     * @param $para_temp 请求前的参数数组
     * @return 要请求的参数数组
     */
    public function buildRequestPara($para_temp)
    {
        //除去待签名参数数组中的空值和签名参数
        $para_filter = paraFilter($para_temp);
        //对待签名参数数组排序
        $para_sort = argSort($para_filter);
        //生成签名结果
        $mysign = $this->buildRequestMysign($para_sort);
        //签名结果与签名方式加入请求提交参数组中
        $para_sort['sign']      = $mysign;
        $para_sort['sign_type'] = strtoupper(trim($this->p_set['sign_type']));
        return $para_sort;
    }

    /**
     * 生成要请求给支付宝的参数数组
     * @param $para_temp 请求前的参数数组
     * @return 要请求的参数数组字符串
     */
    public function buildRequestParaToString($para_temp)
    {
        //待请求参数数组
        $para = $this->buildRequestPara($para_temp);
        //把参数组中所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串，并对字符串做urlencode编码
        $request_data = createLinkstringUrlencode($para);
        return $request_data;
    }

    /**
     * 建立请求，以表单HTML形式构造（默认）
     * @param $para_temp 请求参数数组
     * @param $method 提交方式。两个值可选：post、get
     * @param $button_name 确认按钮显示文字
     * @return 提交表单HTML文本  target='_blank'在苹果机上失效
     */
    public function buildRequestForm($para_temp, $method, $button_name)
    {
        //待请求参数数组
        $para = $this->buildRequestPara($para_temp);

        $sHtml = "<form id='alipaysubmit' name='alipaysubmit' action='" . $this->alipay_gateway_new . "_input_charset=" . trim(strtolower($this->p_set['input_charset'])) . "' method='" . $method . "'>";
        while (list($key, $val) = each($para)) {
            $sHtml .= "<input type='hidden' name='" . $key . "' value='" . $val . "'/>";
        }
        //submit按钮控件请不要含有name属性
        $sHtml = $sHtml . "<input type='submit' class='btnPayment' value='" . $button_name . "'></form>";

        // $sHtml = $sHtml."<script>document.forms['alipaysubmit'].submit();</script>";
        return $sHtml;
    }

    /**
     * 建立请求，以表单URL形式构造（默认）
     * @param $para_temp 请求参数数组
     * @return URL 字串
     * &not 会被转译成 ¬ ，所以用 &amp 代替 &。但在实际生产时 $payurl = str_replace('&amp','&',$payurl);// 替换实体字符
     */
    public function buildRequestURL($para_temp)
    {
        //待请求参数数组
        $para = $this->buildRequestPara($para_temp);

        $sHtml = $this->alipay_gateway_new . "_input_charset=" . trim(strtolower($this->p_set['input_charset']));
        while (list($key, $val) = each($para)) {
            $sHtml .= '&amp' . $key . '=' . $val;
        }

        // return urlencode($sHtml);// 不是所需的
        return $sHtml;
    }

    /**
     * 建立请求，以模拟远程HTTP的POST请求方式构造并获取支付宝的处理结果
     * @param $para_temp 请求参数数组
     * @return 支付宝处理结果
     */
    public function buildRequestHttp($para_temp)
    {
        $sResult = '';
        //待请求参数数组字符串
        $request_data = $this->buildRequestPara($para_temp);
        //远程获取数据
        $sResult = getHttpResponsePOST($this->alipay_gateway_new, $this->p_set['cacert'], $request_data, trim(strtolower($this->p_set['input_charset'])));
        return $sResult;
    }

    /**
     * 建立请求，以模拟远程HTTP的POST请求方式构造并获取支付宝的处理结果，带文件上传功能
     * @param $para_temp 请求参数数组
     * @param $file_para_name 文件类型的参数名
     * @param $file_name 文件完整绝对路径
     * @return 支付宝返回处理结果
     */
    public function buildRequestHttpInFile($para_temp, $file_para_name, $file_name)
    {
        //待请求参数数组
        $para                  = $this->buildRequestPara($para_temp);
        $para[$file_para_name] = "@" . $file_name;

        //远程获取数据
        $sResult = getHttpResponsePOST($this->alipay_gateway_new, $this->p_set['cacert'], $para, trim(strtolower($this->p_set['input_charset'])));

        return $sResult;
    }

    /**
     * 用于防钓鱼，调用接口query_timestamp来获取时间戳的处理函数
     * 注意：该功能PHP5环境及以上支持，因此必须服务器、本地电脑中装有支持DOMDocument、SSL的PHP配置环境。建议本地调试时使用PHP开发软件
     * return 时间戳字符串
     */
    public function query_timestamp()
    {
        $url         = $this->alipay_gateway_new . "service=query_timestamp&partner=" . trim(strtolower($this->p_set['partner'])) . "&_input_charset=" . trim(strtolower($this->p_set['input_charset']));
        $encrypt_key = "";

        $doc = new DOMDocument();
        $doc->load($url);
        $itemEncrypt_key = $doc->getElementsByTagName("encrypt_key");
        $encrypt_key     = $itemEncrypt_key->item(0)->nodeValue;

        return $encrypt_key;
    }
}