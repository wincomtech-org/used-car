<?php
namespace app\insurance\validate;

use think\Validate;

class OrderValidate extends Validate
{
    protected $rule = [
        'dead_time' => 'require',
    ];
    protected $message = [
        'dead_time.require' => '失效时间不能为空'
    ];
    protected $scene = [
       // 'add'  => ['name,parent_id'],
       // 'edit' => ['parent_id'],
    ];

}