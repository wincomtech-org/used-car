<?php
namespace app\service\validate;

use think\Validate;

class ServiceValidate extends Validate
{
    protected $rule = [
        'model_id' => 'require',
        'user_id' => 'checkUid',
    ];
    protected $message = [
        'model_id' => '请选择模型！',
        'user_id' => '系统未检测到该用户！',
    ];
    protected $scene = [
       'add'  => ['model_id','user_id'],
       'edit' => [],
    ];
    protected function checkUid($value)
    {
        if (model('Service')->where('id',$value)->count()) {
            return true;
        }
        return false;
    }
}