<?php
namespace app\shop\validate;

use think\Validate;
// use think\Db;

class BrandValidate extends Validate
{
    protected $rule = [
        'name'  => 'require|checkName',
    ];
    protected $message = [
        'name.require'  => '名称不能为空',
        'name.checkName'=> '名称已存在',
        'name.checkNameEdit'=> '名称已存在',
    ];

    // 场景验证 ， 指定场景需要验证的字段
    protected $scene = [
       'add'  => ['name'=>['require','checkName']],
       'edit' => ['name'=>['require','checkNameEdit']],
    ];

    // 自定义验证规则
    // 检查名称是否存在
    protected function checkName($value)
    {
        $find = model('ShopBrand')->where('name',$value)->value('id');
        if ($find) {return false;}
        return true;
    }

    protected function checkNameEdit($value,$rule,$data)
    {
        $find = model('ShopBrand')->where(['name'=>$value,'id'=>['neq',$data['id']]])->value('id');
        if ($find>0) {
            return false;
        }
        return true;
    }

}