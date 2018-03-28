<?php
namespace app\shop\model;

use think\Model;

/**
* 购物车模型
*/
class ShopCartModel extends Model
{
    // 购物车列表不分页
    public function getCartList($filter='')
    {
        // $field = 'a.id,a.user_id,a.spec_id,a.goods_id,a.spec_vars,a.number,a.price,a.market_price';
        $list = $this->alias('a')
            ->field('a.*,b.thumbnail,b.name as goods_name')
            ->join('shop_goods b','a.goods_id=b.id','LEFT')
            ->where($filter)
            ->order('id DESC')
            ->select()->toArray();
            // ->paginate(2);

        return $list;
    }
}