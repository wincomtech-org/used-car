<?php
namespace app\shop\model;

// use think\Model;
use app\usual\model\UsualModel;

/**
* 商品属性值模型 cmf_shop_goods_av
*/
class ShopGoodsAvModel extends UsualModel
{
    // protected $hidden = ['delete_time', 'update_time'];
    // 关联属性表
    public function goodsattr()
    {
        return $this->belongsToMany('ShopGoodsAttrModel', 'shop_gav', 'attr_id', 'av_id');
    }

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
        $limit = $this->limitCom($limit);

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

    public function getAttrOptions($selectId=0, $parentId=0, $option='请选择')
    {
        // $data = $this->all()->toArray();
        $data = $this->field('id,name')->where('attr_id',$parentId)->select()->toArray();

        $options = $this->createOptions($selectId, $option, $data);

        return $options;
    }
}