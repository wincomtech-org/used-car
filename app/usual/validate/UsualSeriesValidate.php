<?php
namespace app\usual\validate;

use think\Validate;

class UsualSeriesValidate extends Validate
{
    protected $rule = [
        'brand_id' => 'require',
        'name' => 'require',
        'parent_id'  => 'checkParentId',
    ];
    protected $message = [
        'brand_id.require' => '请选择品牌！',
        'name.require' => '车系名称不能为空！',
        'parent_id'     => '超过了2级',
    ];

    protected $scene = [
       // 'add'  => ['name,brand_id,parent_id'],
       // 'edit' => ['brand_id,parent_id'],
    ];

    // 自定义验证规则
    protected function checkParentId($value)
    {
        $find = model('UsualSeries')->where(['id' => $value])->value('parent_id');
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
}