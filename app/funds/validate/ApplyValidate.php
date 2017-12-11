<?php
namespace app\funds\validate;

use think\Validate;

class ApplyValidate extends Validate
{
    protected $rule = [
        // 'type' => 'require',
        // 'user_id' => 'require',
        // 'order_sn' => 'checkName',
        'account' => 'require',
        'username' => 'require',
        'coin' => 'require|float|between:100,99999',
        'payment' => 'require',
    ];

    protected $message = [
        'account.require' => '账户不能为空',
        'username.require' => '姓名不能为空',
        'coin.require' => '金额不能为空',
        'coin.float' => '金额必须为数字型',
        'coin.between' => '金额范围不对',
        'payment.require' => '支付方式不能为空',
    ];

    protected $scene = [
        'recharge'  => ['coin','payment'],
        'withdraw' => [],
    ];

    protected function checkName($value,$rule,$data)
    {
        if (model('FundsApply')->where(['id'=>$data['id'],'order_sn'=>$value])->count()) {
            return false;
        }
        return true;
    }
}