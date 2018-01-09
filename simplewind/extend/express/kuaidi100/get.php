<?php
$typeCom = trim($_GET['com']);//快递公司
$typeNu = trim($_GET['nu']);//快递单号

// echo $typeCom.'<br/>' ;
// echo $typeNu;

$AppKey='29833628d495d7a5';//请将XXXXXX替换成您在http://kuaidi100.com/app/reg.html申请到的KEY
$url = 'http://api.kuaidi100.com/api?id='.$AppKey.'&com='.$typeCom.'&nu='.$typeNu.'&show=2&muti=1&order=asc';
// $url = 'http://www.kuaidi100.com/applyurl?key=23f6c1fa2a0f7dc3&com='.$typeCom.'&nu='.$typeNu;

//请勿删除变量$powered 的信息，否者本站将不再为你提供快递接口服务。
$powered = '查询数据由：<a href="http://kuaidi100.com" target="_blank">KuaiDi100.Com （快递100）</a> 网站提供 ';


//优先使用curl模式发送数据
if (function_exists('curl_init') == 1){
  $curl = curl_init();
  curl_setopt ($curl, CURLOPT_URL, $url);
  curl_setopt ($curl, CURLOPT_HEADER,0);
  curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt ($curl, CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
  curl_setopt ($curl, CURLOPT_TIMEOUT,5);
  $get_content = curl_exec($curl);
  curl_close ($curl);
}else{
  include("snoopy.php");
  $snoopy = new snoopy();
  $snoopy->referer = 'http://www.google.com/';//伪装来源
  $snoopy->fetch($url);
  $get_content = $snoopy->results;
}
print_r($get_content . '<br/>' . $powered);
exit();
?>


<?php 
// 更加简单粗暴的方法

/**
* 返回快递100查询链接 by wang 
* URL：https://code.google.com/p/kuaidi-api/wiki/Open_API_Chaxun_URL
*/
// function kuaidi100($invoice_sn){
//     $url = 'http://m.kuaidi100.com/query?type=tiantian&postid=' .$invoice_sn. '&temp='.time();
//     return $url;
// }

// public function kuaidi($invoice_no, $shipping_name) {
//   switch ($shipping_name) {
//     case '中国邮政':$logi_type = 'ems';
//     break;
//     case '申通快递':$logi_type = 'shentong';
//     break;
//     case '圆通速递':$logi_type = 'yuantong';
//     break;
//     case '顺丰速运':$logi_type = 'shunfeng';
//     break;
//     case '韵达快递':$logi_type = 'yunda';
//     break;
//     case '天天快递':$logi_type = 'tiantian';
//     break;
//     case '中通速递':$logi_type = 'zhongtong';
//     break;
//     case '增益速递':$logi_type = 'zengyisudi';
//     break;
//   } 
//   $kurl = 'http://www.kuaidi100.com/query?type=' . $logi_type . '&postid=' . $invoice_no;
//   $ret = $this -> curl_get_contents($kurl);
//   $k_arr = json_decode($ret, true);
//   return $k_arr;
// }
?>


<?php 
  /**
   * 从第三方取快递信息
   *
   */
  // public function get_expressOp(){
  //       $url = 'http://www.kuaidi100.com/query?type='.$_GET['e_code'].'&postid='.$_GET['shipping_code'].'&id=1&valicode=&temp='.random(4).'&sessionid=&tmp='.random(4);
  //       import('function.ftp');
  //       $content = dfsockopen($url);
  //       $content = json_decode($content,true);
  //       if ($content['status'] != 200) exit(json_encode(false));
  //       $content['data'] = array_reverse($content['data']);
  //       $output = '';
  //       if (is_array($content['data'])){
  //           foreach ($content['data'] as $k=>$v) {
  //               if ($v['time'] == '') continue;
  //               $output .= '<li>'.$v['time'].'&nbsp;&nbsp;'.$v['context'].'</li>';
  //           }
  //       }
  //       if ($output == '') exit(json_encode(false));
  //       if (strtoupper(CHARSET) == 'GBK'){
  //           $output = Language::getUTF8($output);//网站GBK使用编码时,转换为UTF-8,防止json输出汉字问题
  //       }
  //       echo json_encode($output);
  // }
?>