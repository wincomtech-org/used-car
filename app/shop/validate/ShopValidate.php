<?php
namespace app\shop\validate;

use think\Validate;

/**
* 店铺验证
*/
class ShopValidate extends Validate
{
    protected $rule = [];
    protected $message = [];
    protected $scene = [];

    protected function FunctionName($value,$rule,$data)
    {
        return true;
    }
}