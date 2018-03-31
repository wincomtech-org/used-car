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
    public function getLists($filter=[], $order='', $limit='', $extra=[], $field='')
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
        // 属性处理
        if (!empty($filter['avIds'])) {
            $where['a.avids'] = $this->fixAttr($filter['avIds']);
        }
        if (!empty($extra)) {
            $where = array_merge($where,$extra);
        }
        // 其它项
        $field = empty($field) ? 'a.*,b.name cate_name,c.name brand_name' : $field;
        $join = [
            ['shop_goods_category b','a.cate_id=b.id','LEFT'],
            ['shop_brand c','a.brand_id=c.id','LEFT'],
            // ['shop_gav d','a.id=d.goods_id','LEFT'],
        ];
        $order = empty($order) ? 'a.id DESC' : $order;
        $limit = $this->limitCom($limit);

        $list = $this->alias('a')
            // ->distinct('a.goods_id')
            ->field($field)
            ->join($join)
            ->where($where)
            ->order($order)
            // ->fetchSql(true)->select();
            ->paginate($limit);
// dump($list);die;
        return $list;
    }

    /**
     * [FunctionName description]
     * @param string $value [description]
     */
    public function getGoodsStatus($status='')
    {
        return $this->getStatus($status,'shop_goods_status');
    }

    public function fixAttr($avs='')
    {
        if (is_string($avs)) {
            $avids = explode('_',trim($avs));
        } else {
            $avids = (array)$avs;
        }
        sort($avids);
        $avids = implode('',$avids);
        $avids = (strlen($avids)>32)?md5($avids):$avids;

        return $avids;
    }



    /*获取分类商品 - 用于商城首页*/
    public function getGoodsByCate($value='')
    {
        $cates = model('ShopGoodsCategory')->getGoodsTreeArray();
        // return $cates;
        $cateIds = array_keys($cates);
        // return $cateIds;
        $where = [
            'status' => 1,
            'cate_id_1' => ['in',$cateIds]
        ];
        $goodslist = $this->field('id,name,thumbnail,price,comments,cate_id_1')->where($where)->select()->toArray();
        // return $goodslist;
        $glist = [];
        foreach ($goodslist as $row) {
            $glist[$row['cate_id_1']][] = $row;
        }
        foreach ($cateIds as $key) {
            $cates[$key]['goods'] = isset($glist[$key]) ? $glist[$key] : [];
        }
        return $cates;
    }

    // 热卖
    public function getGoodsHot($limit=10)
    {
        $where = [
            'status' => 1,
            'is_hot' => 1,
        ];
        $goods = $this->field('id,name,thumbnail,price')->where($where)->limit($limit)->select()->toArray();

        return $goods;
    }

}