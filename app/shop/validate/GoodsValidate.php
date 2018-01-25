<?php
namespace app\shop\validate;

use think\Validate;

/**
* 商品验证
*/
class GoodsValidate extends Validate
{
    protected $rule = [];
    protected $message = [];
    protected $scene = [];

    protected function FunctionName($value,$rule,$data)
    {
        return true;
    }
}