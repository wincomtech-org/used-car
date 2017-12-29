<?php
/*微信通用方法*/

function wxTest($value='微信公共方法测试')
{
    return $value;
}

// 获取用户openid
// function getOpenid()
// {
//     $tools = new JsApiPay();
//     $openid = $tools->GetOpenid();
//     // session('openid',$openid);
//     return $openid;
// }

// 日志
function paylog($data='string')
{
    if (is_string($data)) {
        $content = $data;
    } elseif (is_array($data)) {
        $content = json_encode($data);
    } else {
        $content = '非法数据！';
    }
    require_once 'log.php';
    //初始化日志
    $logHandler= new CLogFileHandler("data/wxpaylog/".date('Y-m').'.log');
    $log = Log::Init($logHandler, 15);
}

// 将URL生成二维码
function QRcodeByUrl($url='')
{
    // ToUrlParams();
    error_reporting(E_ERROR);
    import('paymentOld/common/wxpay/lib/phpqrcode',EXTEND_PATH);
    if (empty($url)) {
        $url = '这是一个二维码样例';
        // $url = $_SERVER['HTTP_HOST'];
        // $url = 'http://www.baidu.com';
        // $url = $_GET['url'];
    }
    $url = urldecode($url);
    QRcode::png($url);
}

//打印数组信息
function printf_info($data)
{
    foreach($data as $key=>$value){
        echo "<font color='#00ff55;'>$key</font> : $value <br/>";
    }
}

/**
 * 获取当前的 url 地址
 * @return type
*/
function getThisUrl() {
    $sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
    $php_self = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
    $path_info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
    $relate_url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $php_self.(isset($_SERVER['QUERY_STRING']) ? '?'.$_SERVER['QUERY_STRING'] : $path_info);

    return $sys_protocal.(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '').$relate_url;
}



?>