<?php
namespace app\trade\model;

use think\Model;
use think\Db;

/**
* 交易模型
*/
class TradeModel extends Model
{
    // 卖车资质验证
    public function check_sell($uid=null, $code='certification', $data=false)
    {
        // 实名认证
        $identify = lothar_verify();
        if ($identify!=1) {
            $rs = [0,'您未进行实名认证，请上传身份证',url('user/Profile/center')];
            return $rs;
        }
        // 开店资料审核 config('verify_define_data');
        $verify = lothar_verify($uid,'seller');
        if ($verify!=1) {
            return [0,'您的个人审核资料未通过',url('user/Seller/audit')];
        }
        // 是否第一次申请登记 如果是交保证金 deposit
        $result = Db::name('funds_apply')->where(['user_id'=>$uid,'type'=>'openshop'])->find();
        if (empty($result)) {
            // session('deposit_'.$uid, $data);
            return [0,'系统检测到您还未交保证金',url('trade/Post/deposit')];
        }
        // 是否支付开店押金
        if ($result['status']!=10) {
            return [0,'押金未支付',url('user/Funds/apply',['type'=>'openshop'])];
        }
    }

}