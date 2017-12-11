<?php
namespace app\funds\validate;

use think\Validate;
use think\Db;

class FundsValidate extends Validate
{
    protected $rule = [
        'uname'   => 'require|checkUname',
        'ticket'  => 'require|float',
        'account' => 'require',
        'username'=> 'require',
        'coin'    => 'require|float|between:100,99999',
        'payment' => 'require',
    ];
    protected $message = [
        'uname.require'     => '请输入所要充值的用户信息',
        'uname.checkUname'  => '不存在该用户！请检查',
        'ticket.require'    => '点券不能为空',
        'ticket.float'    => '点券必须为数字型',
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
        'coin' => ['uname','coin'=>'require'],
        'ticket' => ['uname','ticket'=>'require'],
    ];

    protected function checkUname($value,$rule,$data)
    {
        $uid = intval($value);
        if (empty($uid)) {
            $uid = Db::name('user')->whereOr(['user_nickname|user_login|user_email|mobile'=>$value])->value('id');
            $uid = intval($uid);
            if (empty($uid)) return false;
        } else {
            $count = Db::name('user')->where('id',$uid)->count();
            if (empty($count)) return false;
        }
        return true;
    }
}
