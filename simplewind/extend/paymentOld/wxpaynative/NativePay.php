<?php
namespace paymentOld\wxpaynative;
// require_once "WxPay.Api.php";

use paymentOld\common\wxpay\lib\WxPayApi;
use paymentOld\common\wxpay\lib\WxPayData;//用不上也要用
use paymentOld\common\wxpay\lib\WxPayBizPayUrl;

/**
 * 
 * 扫码支付实现类
 * @author widyhu
 *
 */
class NativePay
{
	public $p_set;

	// 构造函数
    public function __construct($p_set)
    {
        $this->p_set = $p_set;
        new WxPayData();
    }

	/**
	 * 
	 * 生成扫描支付URL,模式一
	 * @param BizPayUrlInput $bizUrlInfo
	 */
	public function GetPrePayUrl($productId)
	{
		$biz = new WxPayBizPayUrl();
		$biz->SetProduct_id($productId);

		// $api = new WxPayApi($this->p_set);
		// $values = $api->bizpayurl($biz);
		WxPayApi::$p_set = $this->p_set;
		$values = WxPayApi::bizpayurl($biz);

		$url = "weixin://wxpay/bizpayurl?" . $this->ToUrlParams($values);
		return $url;
	}
	
	/**
	 * 
	 * 参数数组转换为url参数
	 * @param array $urlObj
	 */
	private function ToUrlParams($urlObj)
	{
		$buff = "";
		foreach ($urlObj as $k => $v)
		{
			$buff .= $k . "=" . $v . "&";
		}
		
		$buff = trim($buff, "&");
		return $buff;
	}
	
	/**
	 * 
	 * 生成直接支付url，支付url有效期为2小时,模式二
	 * @param UnifiedOrderInput $input
	 */
	public function GetPayUrl($input)
	{
		if($input->GetTrade_type() == "NATIVE")
		{
			WxPayApi::$p_set = $this->p_set;
			$result = WxPayApi::unifiedOrder($input);
			return $result;
		}
	}
}