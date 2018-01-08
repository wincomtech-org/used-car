<?php
<<<<<<< HEAD:simplewind/extend/paymentOld/common/wxpay/lib/WxPayException.php
namespace paymentOld\common\wxpay\lib;

=======
>>>>>>> 32ff6e6b7b6c9e7f15cbceab3dc236face57e84b:simplewind/extend/payment/common/wxpay/v3/WxPayException.php
/**
 * 
 * 微信支付API异常类
 * @author widyhu
 *
 */
class WxPayException extends Exception {
	public function errorMessage()
	{
		return $this->getMessage();
	}
}
