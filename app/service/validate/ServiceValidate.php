<?php
namespace app\service\validate;

use think\Validate;

class ServiceValidate extends Validate
{
    protected $rule = [
        'model_id' => 'require',
        // 'company_id|公司' => 'gt:0',
        'username' => 'checkUname',
        'user_id' => 'require',
    ];
    protected $message = [
        'model_id.require' => '请选择模型',
        // 'company_id.gt' => '请选择公司',
        'user_id' => '系统未检测到该用户！',
    ];
    protected $scene = [
       'add'  => ['model_id','username','user_id'],
       'edit' => ['model_id','username','user_id'],
       'appoint' => ['model_id','username'],
    ];

    protected function checkUid($value)
    {
        if (model('Service')->where('id',$value)->count()) {
            return true;
        }
        return false;
    }
    protected function checkUname($value){
        if (!empty($value)) {
            if (!preg_match('/[\x80-\xff\w\-]+/',$value)) {
                return false;
            }
        }
        return true;
    }
}