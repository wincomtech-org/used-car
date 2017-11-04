<?php
namespace app\usual\validate;

use think\Validate;

class VerifyValidate extends Validate
{
    protected $rule = [
        'auth_code' => 'require',
        // 'user_id' => 'gt:0',
    ];
    protected $message = [
        'auth_code' => '请选择模型',
        // 'user_id' => '系统未检测到该用户！',
    ];
    protected $scene = [
       'add'  => ['auth_code'],
       'edit' => ['auth_code'],
    ];

    protected function checkUid($value)
    {
        if (model('Service')->where('id',$value)->count()) {
            return true;
        }
        return false;
    }
}