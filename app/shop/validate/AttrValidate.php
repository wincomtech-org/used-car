<?php
namespace app\shop\validate;

use think\Validate;

/**
* 商品属性验证
*/
class AttrValidate extends Validate
{
    protected $rule = [];
    protected $message = [];
    protected $scene = [];

    protected function FunctionName($value,$rule,$data)
    {
        return true;
    }
}