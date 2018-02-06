<?php
namespace app\usual\validate;

use think\Validate;
use think\Db;

class ItemCateValidate extends Validate
{
    protected $rule = [
        'id'    => 'require',
        'parent_id'  => 'checkParentId',
        'name'  => 'require|checkName',
        'code|字段码'  => 'require|alphaDash|checkCode|checkCodeEdit',
        'code_type' => 'checkCodeType',
    ];
    protected $message = [
        'id.require'  => 'ID丢失',
        'parent_id.checkParentId' => '超过了2级',
        'name.require'  => '名称不能为空',
        'name.checkName'  => '名称已存在！',
        'code.require'  => '字段码不能为空',
        'code.alphaDash'  => '字段码只能是以字母开头的字母、数字、下划线(_)及破折号(-)组合',
        'code.checkCode'  => '字段码已存在！',
        'code_type.checkCodeType' => '一级字段码类型只能选默认，二级的不能选默认',
    ];

    protected $scene = [
       'add'  => ['parent_id','name','code'=>['require','alphaDash','checkCode'],'code_type'],
       'edit' => ['id','parent_id','code'=>['require','alphaDash','checkCodeEdit'],'code_type'],
    ];

    // 自定义验证规则
    protected function checkParentId($value)
    {
        $find = Db::name('UsualItemCate')->where(['id' => $value])->value('parent_id');
        if ($find) {
            return false;
            // $find2 = Db::name('UsualItemCate')->where(["id" => $find])->value('parent_id');
            // if ($find2) {
            //     return false;
            // }
        }
        return true;
    }

    protected function checkName($value,$rule,$data)
    {
        $find = Db::name('UsualItemCate')->where(['parent_id'=>$data['parent_id'],'name'=>$value])->count();
        if ($find>0) return false; return true;
    }

    protected function checkCode($value)
    {
        $find = Db::name('UsualItemCate')->where(['code'=>$value])->count();
        if ($find>0) return false;return true;
    }

    protected function checkCodeEdit($value,$rule,$data)
    {
        $find = Db::name('UsualItemCate')->where(['code'=>$value,'id'=>['neq',$data['id']]])->count();
        if ($find>0) return false;return true;
    }

    protected function checkCodeType($value,$rule,$data)
    {
        if ($data['parent_id']==0 && $value=='all' or $data['parent_id']>0 && $value!='all') return true;return false;
    }
}