<?php
namespace app\shop;

use think\Model;

/**
 * 服务商城 消息处理模型
 */
class ShopNewsModel extends Model
{
    public function getSNs($filter = '')
    {
        # code...
    }
    public function addSN($data)
    {
        $log = [
            'from_uid'    => isset($data['from_uid']) ? $data['from_uid'] : cmf_get_current_admin_id(),
            'to_uid'      => $data['buyer_uid'],
            'obj_type'    => isset($data['obj_type']) ? $data['obj_type'] : 'order3',
            'obj_id'      => $data['obj_id'],
            'obj_name'    => $data['obj_name'],
            'obj_thumb'   => isset($data['obj_thumb']) ? $data['obj_thumb'] : '',
            'create_time' => time(),
        ];

        $this->allowField(true)->save($log);
    }
}
