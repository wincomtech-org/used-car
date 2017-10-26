<?php
namespace app\insurance\validate;

use think\Validate;

class InsuranceValidate extends Validate
{
    protected $rule = [
        'name'  => 'require',
    ];
    protected $message = [
        'name.require' => '名称不能为空',
    ];

    protected $scene = [
       // 'add'  => ['name,parent_id'],
       // 'edit' => ['parent_id'],
    ];

}