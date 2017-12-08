<?php
namespace app\user\validate;

use think\Validate;

class FundsValidate extends Validate
{
    protected $rule = [
        'account' => 'require',
        'username' => 'require',
        'coin' => 'require|number|length:3,5',
        'payment' => 'require',
    ];
    protected $message = [
        'account.require' => '账户不能为空',
        'username.require' => '姓名不能为空',
        'coin.require' => '金额不能为空',
        'coin.number' => '金额格式不对',
        'coin.length' => '金额范围不对',
        'payment.require' => '支付方式不能为空',
    ];

    protected $scene = [
        'recharge'  => ['coin'],
        'withdraw' => [],
    ];
}
