<?php
namespace app\usual\validate;

use think\Validate;

class UsualSeriesValidate extends Validate
{
    protected $rule = [
        'brand_id' => 'require',
        'name' => 'require',
    ];
    protected $message = [
        'brand_id.require' => '请指定车系类！',
        'name.require' => '车系名称不能为空！',
    ];

    protected $scene = [
       // 'add'  => ['user_login,user_pass,user_email'],
       // 'edit' => ['user_login,user_email'],
    ];
}