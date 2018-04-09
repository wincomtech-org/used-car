<?php
namespace app\shop\model;

use think\Model;


/**
* 每个商品规格
*/
class ShopGoodsSpecModel extends Model
{
    public function getGoodsBySpec($filter='')
    {
        $det = $this->alias('a')
            ->field('a.id as spec_id,a.goods_id,a.price,b.name as goods_name,b.thumbnail')
            ->join('shop_goods b','a.goods_id=b.id')
            ->where($filter)
            ->find()->toArray();
        return $det;
    }

}