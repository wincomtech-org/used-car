<?php
namespace app\trade\validate;

use think\Validate;
use think\Db;

class ReportCateValidate extends Validate
{
    protected $rule = [
        'id'    => 'require',
        'parent_id'  => 'checkParentId',
        'name'  => 'require|checkName',
    ];
    protected $message = [
        'parent_id.checkParentId' => '超过了3级',
        'name.require' => '名称不能为空',
        'name.checkName' => '名称已存在！',
    ];

    protected $scene = [
       'add'  => ['parent_id'=>'checkParentId','name'],
       'edit' => ['id','parent_id'=>'checkParentId'],
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
}