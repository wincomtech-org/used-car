<?php
namespace app\service\validate;

use think\Validate;
use think\Db;

/**
* 
*/
class DefineValidate extends Validate
{
    protected $rule = [
        'name' => 'require|chsAlpha|checkName|checkNameEdit',
        'code' => 'require|alphaDash',
    ];
    protected $message = [
        'name.require' => '字段名必填！',
        'name.checkName' => '已存在同名！',
        'name.checkNameEdit' => '已存在请改名！',
        'code.require' => '客户字段码不能为空!',
    ];
    protected $scene = [
       'add'  => ['name'=>['require','chsAlpha','checkName'],'code'],
       'edit' => ['name'=>['require','chsAlpha','checkNameEdit'],'code'],
    ];
    protected function checkName($value)
    {
        $find = Db::name('service_define')->where('name',$value)->value('id');
        if ($find>0) {
            return false;
        }
        return true;
    }
    protected function checkNameEdit($value,$rule,$data)
    {
        $find = Db::name('service_define')->where(['id'=>['neq',$data['id']],'name'=>$value])->value('id');
        if ($find>0) {
            return false;
        }
        return true;
    }
}