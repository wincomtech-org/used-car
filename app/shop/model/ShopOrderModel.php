<?php
namespace app\shop\model;

// use think\Model;
use app\usual\model\UsualModel;

/**
* 订单模型
*/
class ShopOrderModel extends UsualModel
{
    
    public function getLists($filter=[], $order='', $limit='', $extra=[])
    {
        $field = 'id,order_sn,buyer_uid,order_amount,tracking_no,refund_status,create_time,status';
        $where = ['delete_time' => 0];

        $keyword = empty($filter['keyword']) ? '' : $filter['keyword'] ;
        if (!empty($keyword)) {
            $where['order_sn'] = ['like',"%$keyword%"];
        }
        
        $limit = $this->limitCom($limit);
        $order = empty($order)?'update_time DESC':$order;

        $list = $this->field($field)
            ->order('id DESC')
            ->where($where)
            ->order($order)
            ->paginate($limit);

        return $list;
    }
}