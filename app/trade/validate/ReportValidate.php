<?php
namespace app\trade\validate;

use think\Validate;
use think\Db;

class ReportValidate extends Validate
{
    protected $rule = [
        'id'  => 'require',
        'cate_id' => 'gt:0',
        'name'  => 'require|checkName|checkNameEdit',
    ];
    protected $message = [
        'id.require'  => 'ID非法',
        'cate_id.gt' => '分类必选',
        'name.require' => '检测值不能为空',
        'name.checkName' => '检测值已存在',
        'name.checkNameEdit' => '检测值不存在',
    ];

    protected $scene = [
       'add'  => ['cate_id','name'=>['require','checkName']],
       'edit' => ['id','cate_id','name'=>['require','checkNameEdit']]
    ];

    // 检查名称是否存在
    protected function checkName($value,$rule,$data)
    {
        $find = Db::name('trade_report')->where(['cate_id'=>$data['cate_id'],'name'=>$value])->count();
        if ($find>0) return false; return true;
    }

    protected function checkNameEdit($value,$rule,$data)
    {
        $find = Db::name('trade_report')->where(['id'=>['neq',$data['id']],'cate_id'=>$data['cate_id'],'name'=>$value])->count();
        if ($find==0) return true; return false;
    }
}