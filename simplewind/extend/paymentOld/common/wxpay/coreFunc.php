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

    // return logResult($content);
}

// 将URL生成二维码
function QRcodeByUrl($url='')
{
    // ToUrlParams();
    error_reporting(E_ERROR);
    import('paymentOld/common/wxpay/lib/phpqrcode',EXTEND_PATH);
    if (empty($url)) {
        $url = $_SERVER['HTTP_HOST'];
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

?>