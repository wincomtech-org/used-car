<?php
namespace app\usual\validate;

use think\Validate;

class UsualItemValidate extends Validate
{
    protected $rule = [
        'name'  => 'require',
        'parent_id'  => 'checkParentId',
    ];
    protected $message = [
        'name.require' => '名称不能为空',
        'parent_id'     => '超过了2级',
    ];

    protected $scene = [
       'add'  => ['parent_id'],
       'edit' => ['name,parent_id'],
       // 'edit' => ['name'=>'require','parent_id'],
    ];

    // 自定义验证规则
    protected function checkParentId($value)
    {
        $find = model('UsualItem')->where(['id' => $value])->value('parent_id');
        if ($find) {
            return false;
            // $find2 = Db::name('UsualBrand')->where(["id" => $find])->value('parent_id');
            // if ($find2) {
            //     $find3 = Db::name('UsualBrand')->where(["id" => $find2])->value('parent_id');
            //     if ($find3) {
            //         return false;
            //     }
            // }
        }
        return true;
    }

    protected function checkName($value)
    {
        $find = model('UsualItem')->where(['name'=>$value])->value('name');
        if ($value==$find) {
            return false;
        }
        // return true;
    }
}