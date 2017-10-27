<?php
namespace app\usual\validate;

use think\Validate;

class CompanyValidate extends Validate
{
    protected $rule = [
        'name'  => 'require|checkName',
    ];
    protected $message = [
        'name.require' => '名称不能为空',
        'name.checkName' => '名称已存在',
    ];

    protected $scene = [
       'add'  => ['name'],
       'edit' => ['name'=>'require'],
    ];

    // 检查名称是否存在
    protected function checkName($value)
    {
        $find = model('UsualCompany')->where('name',$value)->value('id');
        if ($find) {return false;}
        return true;
    }
    protected function checkNameEdit($value)
    {
        $find = model('UsualCompany')->where('name',$value)->value('id');
        if ($find) {return true;}
        return false;
    }

}