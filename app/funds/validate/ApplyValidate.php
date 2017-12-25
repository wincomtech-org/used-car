<?php
namespace app\funds\validate;

use think\Validate;

class ApplyValidate extends Validate
{
    protected $rule = [
        // 'type' => 'require',
        // 'order_sn' => 'checkName',
        'account' => 'require',
        'username' => 'require',
        'payment' => 'require',
    ];

    protected $message = [
        'account.require' => '账户不能为空',
        'username.require' => '姓名不能为空',
        'payment.require' => '支付方式不能为空',
    ];

    protected $scene = [
        'recharge'  => ['coin','payment'],
        'withdraw' => [],
        'openshop' => ['coin','payment'],
    ];

    protected function checkName($value,$rule,$data)
    {
        if (model('FundsApply')->where(['id'=>$data['id'],'order_sn'=>$value])->count()) {
            return false;
        }
        return true;
    }
}