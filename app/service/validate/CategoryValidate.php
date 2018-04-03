<?php
namespace app\service\validate;

use think\Validate;
use think\Db;

class CategoryValidate extends Validate
{
    protected $rule = [
        'name' => 'require|checkName|checkNameEdit',
        'define_data' => 'require',
        'is_pay' => 'checkPay',
    ];
    protected $message = [
        'name.require' => '模型名称必填！',
        'name.checkName' => '模型已存在！',
        'name.checkNameEdit' => '已存在相同模型！',
        'define_data.require' => '客户字段不能为空!',
        'is_pay.checkPay' => '服务费不能为空!',
    ];
    protected $scene = [
       'add'  => ['name'=>['require','checkName'],'define_data','is_pay'],
       'edit' => ['name'=>['require','checkNameEdit'],'define_data','is_pay'],
    ];
    
    protected function checkName($value)
    {
        $find = Db::name('service_category')->where('name',$value)->count();
        if ($find>0) {
            return false;
        }
        return true;
    }

    protected function checkNameEdit($value,$rule,$data)
    {
        $find = Db::name('service_category')->where(['name'=>$value,'id'=>['neq',$data['id']]])->count();
        if ($find>0) {
            return false;
        }
        return true;
    }

    protected function checkPay($value,$rule,$data)
    {
        if ($value==1 && $data['price']<=0) {
            return false;
        }
        return true;
    }
}