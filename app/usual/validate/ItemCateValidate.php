<?php
namespace app\usual\validate;

use think\Validate;

class ItemCateValidate extends Validate
{
    protected $rule = [
        'id'    => 'require',
        'parent_id'  => 'checkParentId',
        'name'  => 'require|checkName',
        'code|字段码'  => 'require|alphaDash|checkCode',
    ];
    protected $message = [
        'parent_id.checkParentId'     => '超过了2级',
        'name.require'  => '名称不能为空',
        'name.checkName'  => '名称已存在！',
        'code.require'  => '字段码不能为空',
        // 'code.alphaDash'  => '字段码只能是以字母开头的字母、数字、下划线(_)及破折号(-)组合',
        'code.checkCode'  => '字段码已存在！',
    ];

    protected $scene = [
       'add'  => ['parent_id','name','code'],
       'edit' => ['id','parent_id'],
    ];

    // 自定义验证规则
    protected function checkParentId($value)
    {
        $find = model('UsualItemCate')->where(['id' => $value])->value('parent_id');
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
        $find = model('UsualItemCate')->where(['parent_id'=>$data['parent_id'],'name'=>$value])->count();
        if ($find) return false; return true;
    }

    protected function checkCode($value)
    {
        $find = model('UsualItemCate')->where(['code'=>$value])->count();
        if ($find) {return false;}
        return true;
    }
}