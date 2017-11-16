<?php
namespace app\insurance\validate;

use think\Validate;

class PostValidate extends Validate
{
    protected $rule = [
        'id' => 'gt:0',
        'insurance_id' => 'gt:0',
        'plateNo' => 'checkCarNum',
        'more.mobile' => 'checkMobile',
    ];
    protected $message = [
        'more.mobile.checkMobile' => '手机号格式不对',
        'plateNo.checkCarNum' => '车牌号格式不对',
    ];
    protected $scene = [
       'step2'  => ['insurance_id'],
       'step3' => ['id','plateNo','more.mobile'],
    ];



    protected function checkCarNum($value)
    {
        return true;
    }
    protected function checkMobile($value)
    {
        return true;
    }
    protected function checkName($value)
    {
        // if (model('Insurance')->where('name',$value)->count()) {
        //     return false;
        // }
        return true;
    }
}