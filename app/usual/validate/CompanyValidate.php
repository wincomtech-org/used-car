<?php
namespace app\usual\validate;

use think\Validate;
use think\Db;

class CompanyValidate extends Validate
{
    protected $rule = [
        'name'  => 'require|checkName',
        'status'=>'checkStatus',
    ];
    protected $message = [
        'name.require' => '名称不能为空',
        'name.checkName' => '名称已存在',
        'name.checkNameEdit' => '修改的名称与其他的冲突',
        'status.checkStatus' => '必须认证通过才能发布',
    ];

    protected $scene = [
       'add'  => ['name'=>['require','checkName'],'status'],
       'edit' => ['name'=>['require','checkNameEdit'],'status'],
    ];

    // 检查名称是否存在
    protected function checkName($value)
    {
        $find = Db::name('usual_company')->where('name',$value)->count();
        if ($find>0) {return false;}
        return true;
    }
    protected function checkNameEdit($value,$rule,$data)
    {
        $find = Db::name('usual_company')->where(['id'=>['neq',$data['id']],'name'=>$value])->count();
        if ($find==0) return true; return false;
    }

    protected function checkStatus($value,$rule,$data)
    {
        if ($value==1 && empty($data['identi_status'])) {
            return false;
        }
        return true;
    }

}