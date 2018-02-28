<?php
namespace app\shop\validate;

use think\Validate;

class GoodsCategoryValidate extends Validate
{
    protected $rule = [
        'parent_id'  => 'checkParentId',
        'name'  => 'require',
    ];
    protected $message = [
        'parent_id.checkParentId' => '超过了2级',
        'name.require' => '分类名称不能为空',
    ];

    protected $scene = [
       // 'add'  => ['user_login,user_pass,user_email'],
       // 'edit' => ['user_login,user_email'],
    ];

    // 自定义验证规则
    protected function checkParentId($value)
    {
        $find = model('ShopGoodsCategory')->where(['id'=>$value])->value('parent_id');
        if ($find) {
            return false;
            // $find2 = Db::name('UsualBrand')->where(["id" => $find])->value('parent_id');
            // if ($find2) {
            //     return false;
            // }
        }
        return true;
    }
    protected function checkName($value,$rule,$data)
    {
        return true;
    }
    protected function checkNameEdit($value,$rule,$data)
    {
        return true;
    }
}