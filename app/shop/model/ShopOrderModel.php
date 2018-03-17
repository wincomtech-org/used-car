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
        $field = '*';
        $where = ['delete_time' => 0];

        $keyword = empty($filter['keyword']) ? '' : $filter['keyword'] ;
        if (!empty($keyword)) {
            $where['order_sn'] = ['like',"%$keyword%"];
        }
        
        // 数据量
        $limit = $this->limitCom($limit);

        $list = $this->field($field)
            ->order('id DESC')
            ->where($where)
            ->paginate($limit);

        return $list;
    }
}