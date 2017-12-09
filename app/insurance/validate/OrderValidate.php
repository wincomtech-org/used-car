<?php
namespace app\insurance\validate;

use think\Validate;

class OrderValidate extends Validate
{
    protected $rule = [
        'insurance_id' => 'require',
        'order_sn' => 'checkName',
        'dead_time' => 'require',
    ];
    protected $message = [
        'insurance_id.require' => '保单ID丢失！',
        'order_sn.checkName' => '保单号已存在！',
        'dead_time.require' => '失效时间不能为空！'
    ];
    protected $scene = [
       'add'  => ['order_sn','dead_time'],
       'edit' => ['dead_time'],
       'agree'=> ['insurance_id'],
    ];
    protected function checkName($value,$rule,$data)
    {
        if (model('InsuranceOrder')->where('order_sn',$value)->count()) {
            return false;
        }
        return true;
    }
}