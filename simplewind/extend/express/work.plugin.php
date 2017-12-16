<?php
/**
 * WincomtechPHP
 * --------------------------------------------------------------------------------------------------
 * 版权所有 2013-2035 XXX网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.wowlothar.cn
 * --------------------------------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在遵守授权协议前提下对程序代码进行修改和使用；不允许对程序代码以任何形式任何目的的再发布。
 * 授权协议：http://www.wowlothar.cn/license.html
 * --------------------------------------------------------------------------------------------------
 * Author: Lothar
 * Release Date: 2015-06-10
 */
if (!defined('IN_LOTHAR')) die('Hacking attempt');

class Plugin {
    var $plugin_id = 'express'; // 插件唯一ID

    /**
     * +----------------------------------------------------------
     * 配送方式列表
     * +----------------------------------------------------------
     */
    function method() {
        // 获取插件配置信息
        $plugin = $GLOBALS['dou']->get_plugin($this->plugin_id);
        
        foreach (explode($plugin['config']['method'], "\n") as $value) {
            $method[] = array(
                    "name" => $row[0],
                    "id" => $row[1],
                    "price" => $row[2],
                    "desc" => $row[3]
            );
        }
    }

    /**
     * +----------------------------------------------------------
     * 配置信息
     * +----------------------------------------------------------
     */
    function p_set() {
        // 获取插件配置信息
        $plugin = $GLOBALS['dou']->get_plugin($this->plugin_id);
        
        // 合作身份者id，以2088开头的16位纯数字
        $p_set['partner']  = $plugin['config']['partner'];
        
        // 收款支付宝账号
        $p_set['seller_email'] = $plugin['config']['seller_email'];
        
        // 安全检验码，以数字和字母组成的32位字符
        $p_set['key']   = $plugin['config']['key'];
        
        // 签名方式 不需修改
        $p_set['sign_type']    = strtoupper('MD5');
        
        // 字符编码格式 目前支持 gbk 或 utf-8
        $p_set['input_charset']= strtolower('utf-8');
        
        // ca证书路径地址，用于curl中ssl校验
        // 请保证cacert.pem文件在当前文件夹目录中
        $p_set['cacert']    = ROOT_PATH . 'include/plugin/' . $this->plugin_id . '/cacert.pem';
        
        // 访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
        $p_set['transport']    = 'http';
        
        return $p_set;
    }

    /**
     * +----------------------------------------------------------
     * 请求参数
     * +----------------------------------------------------------
     */
    function parameter() {
        // 获取插件配置信息
        $plugin = $GLOBALS['dou']->get_plugin($this->plugin_id);

        $parameter['service'] = "create_direct_pay_by_user";
        
        // 合作身份者id，以2088开头的16位纯数字
        $parameter['partner'] = trim($plugin['config']['partner']);
        
        // 收款支付宝账号
        $parameter['seller_email'] = trim($plugin['config']['seller_email']);
        
        //支付类型，必填，不能修改
        $parameter['payment_type'] = "1";
        
        //服务器异步通知页面路径，需http://格式的完整路径，不能加?id=123这类自定义参数
        $parameter['notify_url'] = ROOT_URL . 'include/plugin/' . $this->plugin_id . '/notify_url.php';
        
        //页面跳转同步通知页面路径，需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/
        $parameter['return_url'] = ROOT_URL . 'include/plugin/' . $this->plugin_id . '/return_url.php';
        
        //商户订单号，商户网站订单系统中唯一订单号，必填
        $parameter['out_trade_no'] = $this->order_sn;
        
        //订单名称，必填
        $parameter['subject'] = $GLOBALS['_CFG']['site_name'];
        
        //付款金额，必填
        $parameter['total_fee'] = $this->order_amount;
        
        //订单描述
        $parameter['body'] = "";
        
        //商品展示地址，需以http://开头的完整路径，例如：http://www.商户网址.com/myorder.html
        $parameter['show_url'] = "";
        
        //防钓鱼时间戳，若要使用请调用类文件submit中的query_timestamp函数
        $parameter['anti_phishing_key'] = "";
        
        //客户端的IP地址，非局域网的外网IP地址，如：221.0.0.1
        $parameter['exter_invoke_ip'] = "";
        
        // 字符编码格式 目前支持 gbk 或 utf-8
        $parameter['_input_charset'] = trim(strtolower(strtolower('utf-8')));

        return $parameter;
    }
}
?>