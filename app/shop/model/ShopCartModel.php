<?php
namespace app\shop\model;

use think\Model;

/**
* 购物车模型
*/
class ShopCartModel extends Model
{
    
    public function getCartList($filter='')
    {
        $list = $this->alias('a')
            ->field('a.*,b.thumbnail,b.name')
            ->join('shop_goods b','a.goods_id=b.id')
            ->where($filter)
            ->order('id DESC')
            ->paginate(1);

        return $list;
    }
}