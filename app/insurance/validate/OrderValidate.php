<?php
namespace app\insurance\validate;

use think\Validate;

class OrderValidate extends Validate
{
    protected $rule = [
        'order_sn' => 'checkName',
        'dead_time' => 'require',
    ];
    protected $message = [
        'order_sn.checkName' => '保单号已存在！',
        'dead_time.require' => '失效时间不能为空！'
    ];
    protected $scene = [
       'add'  => ['order_sn','dead_time'],
       'edit' => ['dead_time'],
    ];
    protected function checkName($value='')
    {
        if (model('InsuranceOrder')->where('order_sn',$post['order_sn'])->value('id')) {
            return false;
        }
        return true;
    }
}