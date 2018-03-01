<?php
namespace app\shop\model;

// use think\Model;
use app\usual\model\UsualModel;

/**
* 商品模型 cmf_shop_goods
*/
class ShopGoodsModel extends UsualModel
{
    // 获取列表数据
    public function getLists($filter=[], $order='', $limit='', $extra=[], $field='*')
    {
        // 筛选条件
        $where = [];
        // 分类ID
        if (!empty($filter['cateId'])) {
            $where['a.cate_id'] = $filter['cateId'];
        }
        // 品牌ID
        if (!empty($filter['brandId'])) {
            $where['a.brand_id'] = $filter['brandId'];
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
        // $join = [];
        $order = empty($order) ? 'a.id DESC' : $order;
        $limit = $this->limitCom($limit);

        $series = $this->alias('a')->field($field)
            // ->join($join)
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