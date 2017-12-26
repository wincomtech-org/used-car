<?php
namespace app\usual\validate;

use think\Validate;

class VerifyValidate extends Validate
{
    protected $rule = [
        'auth_code' => 'require',
        'user_id' => 'gt:0',
        'more.username' => 'require',
        'more.contact' => 'require',
        'more.plateNo' => 'require',
        'more.driving_license' => 'require',
        'more.identity_card' => 'require',
    ];
    protected $message = [
        'auth_code' => '请选择模型',
        'user_id' => '系统未检测到该用户！',
        'more.username' => '用户名不能为空！',
        'more.contact' => '联系方式不能为空！',
        'more.plateNo' => '车牌号不能为空！',
        'more.driving_license' => '行车本不能为空！',
        'more.identity_card' => '身份证不能为空！',
    ];
    protected $scene = [
       'add'        => ['auth_code'],
       'edit'       => ['auth_code'],
       'openshop'   => [],
       'insurance'  => [],
    ];

    protected function checkUid($value)
    {
        if (model('Service')->where('id',$value)->count()) {
            return true;
        }
        return false;
    }
}