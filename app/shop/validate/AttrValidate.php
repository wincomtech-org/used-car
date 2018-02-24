<?php
namespace app\shop\validate;

use think\Validate;

/**
* 商品属性验证
*/
class AttrValidate extends Validate
{
    protected $rule = [
        'name'  => 'require',
    ];
    protected $message = [
        'name.require' => '名称不能为空',
    ];
    protected $scene = [
        // 'add' => ['name'],
    ];

    // protected function FunctionName($value,$rule,$data)
    // {
    //     return true;
    // }
}