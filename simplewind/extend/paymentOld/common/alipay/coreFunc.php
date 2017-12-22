<?php
/*微信通用方法*/

function aliTest($value='微信公共方法测试')
{
    return $value;
}

function QRcodeByUrl($url='')
{
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

?>