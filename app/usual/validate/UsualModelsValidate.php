<?php
namespace app\usual\validate;

use think\Validate;
use think\Db;

class UsualModelsValidate extends Validate
{
    protected $rule = [
        'name'  => 'require|checkName',
    ];
    protected $message = [
        'name.require' => '名称不能为空',
        'name.checkName' => '名称已存在',
    ];
    protected $scene = [
       'add'  => ['name'],
       'edit' => ['name'=>'require'],
    ];

    // 检查名称是否存在
    protected function checkName($value)
    {
        $find = Db::name('usual_models')->where('name',$value)->value('id');
        if ($find) {return false;}
        return true;
    }

    protected function checkNameEdit($value,$rule,$data)
    {
        $find = Db::name('usual_models')->where(['id'=>['neq',$data['id']],'name'=>$value])->count();
        if ($find==0) return true; return false;
    }
}