<?php
namespace app\shop\model;

use think\Model;

/**
* 商品规格模型
*/
class ShopSpecModel extends Model
{
    public function getLists($filter=[], $order='', $limit='', $extra=[])
    {
        $where = [];
        $keyword = empty($filter['keyword']) ? '' : $filter['keyword'];
        if (!empty($keyword)) {
            $where['name'] = ['like',"%$keyword%"];
        }
        if (!empty($extra)) {
            $where = array_merge($where,$extra);
        }

        // 排序
        $order = empty($order) ? '' : $order;

        // 数据量
        $limit = empty($limit) ? config('pagerset.size') : $limit;
        
        $list = $this->where($where)
            ->order($order)
            ->paginate($limit);

        return $list;
    }
}