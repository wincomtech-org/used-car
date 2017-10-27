<?php
namespace app\insurance\validate;


use think\Validate;

class CoverageValidate extends Validate
{
    protected $rule = [
        'id'  => 'require',
        'name'  => 'require|checkName',
    ];
    protected $message = [
        'id.require'  => 'ID非法',
        'name.require' => '名称不能为空',
        'name.checkName' => '名称已存在',
    ];

    protected $scene = [
       'add'  => ['name'],
       'edit' => ['id','name'=>'require'],
    ];

    // 检查名称是否存在
    protected function checkName($value)
    {
        $find = model('InsuranceCoverage')->where('name',$value)->value('id');
        if ($find) {
            return false;
        }
        return true;
    }
}