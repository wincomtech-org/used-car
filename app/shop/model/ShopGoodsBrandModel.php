<?php
namespace app\trade\model;

// use think\Model;
use app\usual\model\UsualModel;

/**
* 商品品牌模型 cmf_shop_goods_brand
*/
class ShopGoodsBrandModel extends UsualModel
{
    // 获取列表数据
    public function getLists($filter=[], $order='', $limit='', $extra=[], $field='*')
    {
        // 筛选条件
        $where = [];
        $where = ['a.delete_time' => 0];
        // 属性ID
        if (!empty($filter['attrId'])) {
            $where['a.attrId'] = $filter['attrId'];
        }
        if (!empty($extra)) {
            $where = array_merge($where,$extra);
        }
        // 其它项
        $field = '*';
        $join = [];
        $order = empty($order) ? 'a.id DESC' : $order;
        $limit = empty($limit) ? config('pagerset.size') : $limit;

        $series = $this->alias('a')->field($field)
            ->join($join)
            ->where($where)
            ->order($order)
            ->paginate($limit);

        return $series;
    }

    // 获取单条数据
    public function getPost($id)
    {
        $post = $this->get($id)->toArray();

        return $post;
    }
}