<?php
namespace app\funds\validate;

use think\Validate;
use think\Db;

class FundsValidate extends Validate
{
    protected $rule = [
        'uname'   => 'require|checkUname',
        'coin'    => 'require|float|between:100,99999',
        'score'   => 'require|float',
        'coupon'  => 'require',
        'username'=> 'require',
        'account' => 'require',
        'payment' => 'require',
    ];
    protected $message = [
        'uname.require'     => '请输入所要充值的用户信息',
        'uname.checkUname'  => '不存在该用户！请检查',
        'coin.require'      => '金额不能为空',
        'coin.float'        => '金额必须为数字型',
        'coin.between'      => '金额范围不对',
        'score.require'     => '积分不能为空',
        'score.float'       => '积分必须为数字型',
        'coupon.require'    => '优惠券数额不能为空',
        'username.require'  => '姓名不能为空',
        'account.require'   => '账户不能为空',
        'payment.require'   => '支付方式不能为空',
    ];

    protected $scene = [
        'recharge'  => ['coin','payment'],
        'withdraw'  => [],
        'coin'      => ['uname','coin'=>'require'],
        'score'     => ['uname','score'=>'require'],
        'coupon'    => ['uname','coupon'=>'require'],
    ];

    protected function checkUname($value,$rule,$data)
    {
        $uid = intval($value);
        if (empty($uid)) {
            $uid = model('usual/Usual')->getUid($value);
            if (empty($uid)) return false;
        } else {
            $count = Db::name('user')->where('id',$uid)->count();
            if (empty($count)) return false;
        }
        return true;
    }
}
