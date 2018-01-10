<?php
namespace app\shop\model;

// use think\Model;
use app\usual\model\UsualModel;

/**
* 商品属性模型 cmf_shop_goods_attr
*/
class ShopGoodsAttrModel extends UsualModel
{
    // protected $hidden = ['delete_time', 'update_time'];
    // 关联产品表
    public function goods()
    {
        return $this->belongsToMany('ShopGoodsModel', 'shop_gav', 'proId', 'attrId');
    }
    // 关联分类表
    // public function goodscate()
    // {
    //     return $this->belongsToMany('ShopGoodsCategoryModel', 'shop_gav', 'proId', 'attrId');
    // }

    // 获取列表数据
    public function getLists($filter=[], $order='', $limit='', $extra=[], $field='*')
    {
        // 筛选条件
        $where = [];
        $where = ['a.delete_time' => 0];
        // 分类ID
        if (!empty($filter['cateId'])) {
            $where['a.cateId'] = $filter['cateId'];
        }
        // 创建时间
        $startTime = empty($filter['start_time']) ? 0 : strtotime($filter['start_time']);
        $endTime   = empty($filter['end_time']) ? 0 : strtotime($filter['end_time']);
        if (!empty($startTime) && !empty($endTime)) {
            $where['a.create_time'] = [['>= time', $startTime], ['<= time', $endTime]];
        } else {
            if (!empty($startTime)) {
                $where['a.create_time'] = ['>= time', $startTime];
            }
            if (!empty($endTime)) {
                $where['a.create_time'] = ['<= time', $endTime];
            }
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