<?php
namespace app\usual\validate;

use think\Validate;
use think\Db;

class ItemValidate extends Validate
{
    protected $rule = [
        'id'  => 'require',
        'cate_id' => 'gt:0',
        'name'  => 'require|checkName|checkNameEdit',
    ];
    protected $message = [
        'id.require'  => 'ID非法',
        'cate_id.gt' => '分类必选',
        'name.require' => '属性值不能为空',
        'name.checkName' => '属性值已存在',
        'name.checkNameEdit' => '属性值不存在',
    ];

    protected $scene = [
       'add'  => ['cate_id','name'=>['require','checkName']],
       'edit' => ['id','cate_id','name'=>['require','checkNameEdit']]
    ];

    // 检查名称是否存在
    protected function checkName($value,$rule,$data)
    {
        $find = Db::name('usual_item')->where(['cate_id'=>$data['cate_id'],'name'=>$value])->count();
        if ($find>0) return false; return true;
    }

    protected function checkNameEdit($value,$rule,$data)
    {
        $find = Db::name('usual_item')->where(['id'=>['neq',$data['id']],'cate_id'=>$data['cate_id'],'name'=>$value])->count();
        if ($find==0) return true; return false;
    }
    // protected function checkNameEdit($value,$rule,$data)
    // {
    //     $find = model('UsualItem')->where(['name'=>$value,'cate_id'=>$data['cate_id']])->column('id');
    //     // $diff = array_diff_assoc([intval($data['id'])],$find);
    //     foreach ($find as $ii) {
    //         if ($data['id']!=$ii) {
    //             return false;
    //         }
    //     }
    //     return true;
    // }
}