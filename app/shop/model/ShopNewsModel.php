<?php
namespace app\shop;

use think\Model;

/**
* 服务商城 消息处理模型
*/
class ShopNewsModel extends Model
{
    public function getSNs($filter='')
    {
        # code...
    }
    public function addSN($data)
    {
        $data = [
            'from_uid'  => '',
            'to_uid'  => '',
            'obj_type'  => '',
            'obj_id'  => '',
            'obj_name'  => '',
            'obj_thumb'  => '',
            'create_time'  => time(),
        ];
    }
}