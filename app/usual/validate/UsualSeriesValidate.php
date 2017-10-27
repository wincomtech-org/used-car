<?php
namespace app\usual\validate;

use think\Validate;

class UsualSeriesValidate extends Validate
{
    protected $rule = [
        'parent_id' => 'checkParentId',
        'brand_id'  => 'checkBrand',
        'name'      => 'require|checkName',
    ];
    protected $message = [
        'parent_id'     => '超过了2级',
        'brand_id'      => '请选择品牌！',
        'name.require'  => '车系名称不能为空！',
        'name.checkName'=> '车系名称已存在',
    ];

    protected $scene = [
       'add'  => ['parent_id','brand_id','name'],
       'edit' => ['parent_id','brand_id','name'=>'require'],
    ];

    // 自定义验证规则
    protected function checkParentId($value)
    {
        $find = model('UsualSeries')->where('id','eq',$value)->value('parent_id');
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
    protected function checkBrand($value)
    {
        if (empty($value)) {
            return false;
        }
        return true;
    }
    // 检查名称是否存在
    protected function checkName($value,$rule,$data)
    {
        $find = model('UsualSeries')->where(['name'=>$data['name'],'brand_id'=>$data['brand_id']])->value('id');
        // $find = model('UsualSeries')->where('name',$value)->value('id');
        if ($find) {return false;}
        return true;
    }
    protected function checkNameEdit($value)
    {
        $find = model('UsualSeries')->where('name',$value)->value('id');
        if ($find) {return true;}
        return false;
    }
}