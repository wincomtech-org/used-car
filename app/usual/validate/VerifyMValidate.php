<?php
namespace app\usual\validate;

use think\Validate;

class VerifyMValidate extends Validate
{
    protected $rule = [
        'name' => 'require|checkName',
        'code|模型代码' => 'alpha',
        'more' => 'require',
    ];
    protected $message = [
        'name.require' => '模型名称必填！',
        'name.checkName' => '模型已存在！',
        'more' => '请选择客户填写资料',
    ];
    protected $scene = [
       'add'  => ['name','code','more'],
       'edit' => ['name'=>'require','code','more'],
    ];
    protected function checkName($value)
    {
        if (model('VerifyModel')->where('name',$value)->value('id')) {
            return false;
        }
        return true;
    }
}