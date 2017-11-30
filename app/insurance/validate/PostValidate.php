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
        'plateNo' => 'require|isPlateNo',
        'mobile' => 'checkMobile',
    ];
    protected $message = [
        'insurance_id.gt' => '保险ID丢失',
        'car_id.require' => '车子信息丢失',
        'username.require' => '姓名必填',
        'contact.require' => '联系方式必填',
        'driving_license.require' => '行车本照片必填',
        'plateNo.require' => '车牌号必填',
        'plateNo.isPlateNo' => '车牌号格式不对',
        'mobile.checkMobile' => '手机号格式不对',
    ];
    protected $scene = [
       'step2'  => ['insurance_id'],
       'step3'  => ['car_id'],
       'car'    => ['username','contact','driving_license','plateNo'],
    ];


    protected function isPlateNo($value)
    {
        $pattern = '/^[京津沪渝冀豫云辽黑湘皖鲁新苏浙赣鄂桂甘晋蒙陕吉闽贵粤青藏川宁琼使领A-Z]{1}[A-Z]{1}[A-Z_0-9]{5}$/';
        if (preg_match($pattern,$value)) {
            return true;
        }
        return false;
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