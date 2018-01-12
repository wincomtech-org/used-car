<?php
namespace app\usual\validate;

use think\Validate;

class ConsignValidate extends Validate
{
    protected $rule = [
        'company_id'  => 'require|gt:0',
        'sc_id'  => 'require|gt:0',
        'name'  => 'require|checkName',
        'ucs_x'  => 'require|float',
        'ucs_y'  => 'require|float',
    ];
    protected $message = [
        'company_id.require' => '所属公司必选',
        'company_id.gt' => '公司ID非法',
        'sc_id.require' => '所属公司必选',
        'sc_id.gt' => '公司ID非法',
        'name.require' => '坐标名称必填',
        'name.checkName' => '坐标名称已存在！',
        'ucs_x.require' => '修改的名称与其他的冲突',
        'ucs_x.float' => '横坐标格式非法，参考：0.00',
        'ucs_y.require' => '必须认证通过才能发布',
        'ucs_y.float' => '纵坐标格式非法，参考：0.00',
    ];

    protected $scene = [
       'add'  => ['sc_id','name','ucs_x','ucs_y'],
       'edit' => ['sc_id','name'=>'require','ucs_x','ucs_y'],
    ];

    protected function checkName($value)
    {
        $find = model('UsualCoordinate')->where('name',$value)->count();
        if($find>0)return false; return true;
    }
    // 检查坐标格式的合法性
    protected function checkUcs($value)
    {
        $find = model('UsualCoordinate')->where('ucs_x|ucs_y',$value)->count();
        if ($find>0) {return false;}
        return true;
    }

}