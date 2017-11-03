<?php
namespace app\service\validate;

use think\Validate;

class ServiceValidate extends Validate
{
    protected $rule = [
        'model_id' => 'require',
        'company_id' => 'gt:0',
    ];
    protected $message = [
        'model_id' => '请选择模型',
        'company_id' => '请选择公司',
        // 'user_id' => '系统未检测到该用户！',
    ];
    protected $scene = [
       'add'  => ['model_id','company_id'],
       'edit' => ['model_id','company_id'],
    ];

    protected function checkUid($value)
    {
        if (model('Service')->where('id',$value)->count()) {
            return true;
        }
        return false;
    }
}