<?php
namespace app\shop\validate;

use think\Validate;
use think\Db;

/**
* 商品验证
*/
class GoodsValidate extends Validate
{
    protected $rule = [
        'cate_id'  => 'require',
        'name'  => 'require',
    ];
    protected $message = [
        'cate_id.require' => '超过了2级',
        'name.require' => '商品标题不能为空',
        'name.checkName' => '商品标题已存在',
    ];

    protected $scene = [
       'add' => ['cate_id','name'=>['require','checkName']],
       'edit' => ['cate_id','name'=>'require'],
    ];

    // 自定义验证规则
    protected function checkName($value)
    {
        $find = Db::name('shop_goods')->where('name',$value)->count();
        if ($find>0) {
            return false;
        }
        return true;
    }
    protected function checkNameEdit($value,$rule,$data)
    {
        return true;
    }

}