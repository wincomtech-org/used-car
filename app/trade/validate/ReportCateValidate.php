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
        'code_type' => 'checkCodeType',
    ];
    protected $message = [
        'parent_id.checkParentId' => '超过了3级',
        'name.require' => '名称不能为空',
        'name.checkName' => '名称已存在！',
        'code.require' => '字段码不能为空',
        'code_type.checkCodeType' => '一级字段码类型只能选默认，二级的不能选默认',
    ];

    protected $scene = [
       'add'  => ['parent_id'=>'checkParentId','name','code','code_type'],
       'edit' => ['id','parent_id'=>'checkParentId','code_type'],
    ];

    // 自定义验证规则
    protected function checkParentId($value)
    {
        $mQuery = Db::name('trade_report_cate');
        $find = $mQuery->where(['id'=>$value])->value('parent_id');
        if ($find>0) {
            $find2 = $mQuery->where(['id'=>$find])->value('parent_id');
            if ($find2>0) {
                return false;
            }
        }
        return true;
    }

    protected function checkName($value,$rule,$data)
    {
        $find = Db::name('trade_report_cate')->where(['parent_id'=>$data['parent_id'],'name'=>$value])->count();
        if ($find>0) return false; return true;
    }

    protected function checkCodeType($value,$rule,$data)
    {
        if ($data['parent_id']==0 && $value=='all' or $data['parent_id']>0 && $value!='all') return true;return false;
    }
}