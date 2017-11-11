<?php
namespace app\usual\validate;

use think\Validate;

class ItemValidate extends Validate
{
    protected $rule = [
        'id'  => 'require',
        'cate_id' => 'gt:0',
        'name'  => 'require|checkName',
    ];
    protected $message = [
        'id.require'  => 'ID非法',
        'cate_id.gt' => '分类属性必选',
        'name.require' => '属性值不能为空',
        'name.checkName' => '名称已存在',
    ];

    protected $scene = [
       'add'  => ['cate_id','name'],
       'edit' => ['id','cate_id','name'=>'require']
    ];

    // 检查名称是否存在
    protected function checkName($value)
    {
        $find = model('UsualItem')->where('name',$value)->count();
        if ($find) return false; return true;
    }
}