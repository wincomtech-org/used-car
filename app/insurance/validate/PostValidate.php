<?php
namespace app\insurance\validate;

use think\Validate;

class PostValidate extends Validate
{
    protected $rule = [
        'id' => 'gt:0',
        'insurance_id' => 'gt:0',
        'car_id'=>'require',
        'username'=>'require',
        'contact'=>'require',
        'driving_license'=>'require',
        'plateNo' => 'require|checkCarNum',
        'mobile' => 'checkMobile',
    ];
    protected $message = [
        'insurance_id.gt' => '保险ID丢失',
        'car_id.require' => '车子信息丢失',
        'username.require' => '姓名必填',
        'contact.require' => '联系方式必填',
        'driving_license.require' => '行车本照片必填',
        'plateNo.require' => '车牌号必填',
        'plateNo.checkCarNum' => '车牌号格式不对',
        'mobile.checkMobile' => '手机号格式不对',
    ];
    protected $scene = [
       'step2'  => ['insurance_id'],
       'step3'  => ['car_id'],
       'car'    => ['username','contact','driving_license','plateNo'],
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