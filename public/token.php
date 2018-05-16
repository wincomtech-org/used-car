<?php 
/*微信Token验证*/

// define("TOKEN", "weixin");

// 1. 将timestamp , nonce , token 按照字典排序
$timestamp = $_GET['timestamp'];
$nonce = $_GET['nonce'];
$token = "datong";
$signature = $_GET['signature'];
$tmpArr = array($token,$timestamp,$nonce);  
sort($tmpArr,SORT_STRING);  
  
// 2.将排序后的三个参数拼接后用sha1加密  
$tmpStr = implode($tmpArr);  
$tmpStr = sha1($tmpStr);  

// 3. 将加密后的字符串与 signature 进行对比, 判断该请求是否来自微信  
if($tmpStr == $signature)  
{  
    echo $_GET['echostr'];  
    exit;  
}

?>