<?php
namespace app\service\validate;

use think\Validate;

class CategoryValidate extends Validate
{
    protected $rule = [
        'name' => 'require|checkName',
    ];
    protected $message = [
        'name.require' => '模型名称必填！',
        'name.checkName' => '模型已存在！',
    ];
    protected $scene = [
       'add'  => ['name'],
       'edit' => ['name'],
    ];
    protected function checkName($value)
    {
        if (model('ServiceCategory')->where('name',$value)->value('id')) {
            return false;
        }
        return true;
    }
}