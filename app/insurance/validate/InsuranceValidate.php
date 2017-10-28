<?php
namespace app\insurance\validate;

use think\Validate;

class InsuranceValidate extends Validate
{
    protected $rule = [
        'id'  => 'require',
        'name'  => 'require|checkName|checkNameEdit',
        'company_id|公司ID ' => 'gt:0',
    ];
    protected $message = [
        'id.require'  => 'ID非法',
        'name.require' => '名称不能为空',
        'name.checkName' => '名称已存在',
        'name.checkNameEdit' => '名称不存在',
        'company_id.require' => '公司必选',
    ];

    protected $scene = [
       'add'  => ['name'=>['require','checkName'],'company_id'],
       'edit' => ['id','name'=>'require','company_id'],
    ];

    // 检查名称是否存在
    protected function checkName($value)
    {
        $find = model('Insurance')->where('name',$value)->value('id');
        if ($find) {return false;}
        return true;
    }
    protected function checkNameEdit($value)
    {
        $find = model('Insurance')->where('name',$value)->value('id');
        if ($find) {return true;}
        return false;
    }
}