<?php
namespace app\service\validate;

use think\Validate;

class CategoryValidate extends Validate
{
    protected $rule = [
        'name' => 'require|checkName',
        'define_data' => 'require',
    ];
    protected $message = [
        'name.require' => '模型名称必填！',
        'name.checkName' => '模型已存在！',
        'define_data.require' => '客户字段不能为空!',
    ];
    protected $scene = [
       'add'  => ['name','define_data'],
       'edit' => ['name'=>'require','define_data'],
    ];
    protected function checkName($value)
    {
        if (model('ServiceCategory')->where('name',$value)->value('id')) {
            return false;
        }
        return true;
    }
}