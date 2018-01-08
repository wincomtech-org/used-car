<?php
namespace app\insurance\validate;

use think\Validate;

class OrderValidate extends Validate
{
    protected $rule = [
        'compIds' => 'require',
        'coverIds' => 'require',
        'more.username' => 'require',
        'more.contact' => 'require',
        'more.plateNo' => 'require',
        'more.driving_license' => 'require',
        'more.identity_card' => 'require',
        'plateNo' => 'require',
        'user_id' => 'gt:0',
        'order_sn' => 'require|checkName',
        'company_id' => 'require',
        'insurance_id' => 'require',
        'amount' => 'number',
        'dead_time' => 'require',
    ];
    protected $message = [
        'compIds.require' => '意向公司没有选',
        'coverIds.require' => '险种未勾选',
        'more.username' => '用户名不能为空！',
        'more.contact' => '联系方式不能为空！',
        'more.plateNo' => '车牌号不能为空！',
        'more.driving_license' => '行车本不能为空！',
        'more.identity_card' => '身份证不能为空！',
        'plateNo.require' => '车牌号丢失',
        'user_id.require' => '系统未检测到该用户！',
        'order_sn.require' => '保单号生成失败！',
        'order_sn.checkName' => '保单号已存在！',
        'company_id.require' => '管理员未指定公司',
        'insurance_id.require' => '管理员未指定保险业务',
        'amount.number' => '保险金未填',
        'dead_time.require' => '失效时间不能为空！',
    ];
    protected $scene = [
       'add'  => ['order_sn','dead_time'],
       'edit' => ['amount','dead_time'],
       'step1' => ['more','compIds'],
       'step2' => ['coverIds','plateNo','user_id','order_sn'],
       'agree'=> ['company_id','insurance_id'],
    ];

    protected function checkName($value,$rule,$data)
    {
        $find = model('InsuranceOrder')->where('order_sn',$value)->count();
        if ($find>0) return false; return true;
    }
}