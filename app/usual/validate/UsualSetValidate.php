<?php
namespace app\usual\validate;

use think\Validate;

class UsualSetValidate extends Validate
{
    protected $rule = [
        'usual.deposit' => 'require',
        'alipay.switch' => 'checkLegal',
        'weixin.switch' => 'checkLegal2',
    ];

    protected $message = [
        'usual.deposit.require'     => '开店保证金必填',
        'alipay.switch.checkLegal'  => '支付宝资料不能为空',
        'weixin.switch.checkLegal2' => '微信资料不能为空',
    ];


    // 自定义验证规则
    protected function checkLegal($value, $rule, $data)
    {
        if ($value==1) {
            $alipay = $data['alipay'];
            if (empty($alipay['account']) || empty($alipay['key']) || empty($alipay['partner'])) {
                return false;
            }
        }
        return true;
    }
    protected function checkLegal2($value, $rule, $data)
    {
        if ($value==1) {
            $weixin = $data['weixin'];
            if (empty($weixin['appid']) || empty($weixin['mchid']) || empty($weixin['key'])) {
                return false;
            }
        }
        return true;
    }

    protected function payKey($value, $rule, $data)
    {
        return true;
    }

}
