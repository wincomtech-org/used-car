<?php
namespace app\trade\validate;

use think\Validate;

class OrderValidate extends Validate
{
    protected $rule = [
        'order_sn' => 'checkName',
        'buyer_username' => 'checkBname',
        'seller_username' => 'checkSname',
        'status' => 'checkStatus|payTime',
    ];
    protected $message = [
        'order_sn.checkName' => '保单号已存在！',
        'buyer_username.checkBname' => '系统未检测到该买家',
        'seller_username.checkSname' => '系统未检测到该卖家',
        'status.checkStatus' => '客户已付款，请修改状态',
        'status.payTime' => '付款时间不对',
    ];
    protected $scene = [
       'add'  => ['order_sn','buyer_username','seller_username'],
       'edit' => [],
    ];
    protected function checkName($value)
    {
        if (model('TradeOrder')->where('order_sn',$value)->value('id')) {
            return false;
        }
        return true;
    }
    protected function checkBname($value)
    {
        if (model('portal/User')->whereOr(['user_login|user_nickname|user_email|mobile'=>['like', "%$value%"]])->value('id')) {
            return true;
        }
        return false;
    }
    protected function checkSname($value)
    {
        if (model('portal/User')->whereOr(['user_login|user_nickname|user_email|mobile'=>['like', "%$value%"]])->value('id')) {
            return true;
        }
        return false;
    }
    // 是否已付款
    protected function checkStatus($value,$rule,$data)
    {
        $find = model('TradeOrder')->where('id',$data['id'])->value('status');
        if ($value<=0 && $find>0) return false; return true;
    }
    // 付款时间
    protected function payTime($value,$rule,$data)
    {
        if ($value>0 && empty($data['pay_time'])) {
            return false;
        }
        return true;
    }
}