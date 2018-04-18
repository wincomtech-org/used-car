<?php
namespace app\shop\model;

use think\Model;

/**
* 购物车模型
*/
class ShopCartModel extends Model
{
    /**
     * 购物车列表不分页
     * 为避免管理员改价，价格等数据应实时获取。购物车表:id,user_id,goods_id,spec_id,number ，去掉 spec_vars,price,market_price
     * @param  string $filter [description]
     * @return [type]         [description]
     */
    public function getCartList($filter='')
    {
        // $field = 'a.id,a.user_id,a.goods_id,a.spec_id,a.spec_vars,a.number,a.price,a.market_price,b.thumbnail,b.name as goods_name';
        $field = 'a.id,a.user_id,a.goods_id,a.spec_id,a.spec_vars,a.number,b.price,b.market_price,b.thumbnail,b.name as goods_name';
        // $field = 'a.id,a.user_id,a.goods_id,a.spec_id,a.number,b.price,b.market_price,b.thumbnail,b.name as goods_name,c.spec_vars';
        $join = [
            ['shop_goods b','a.goods_id=b.id','LEFT'],
            // ['shop_goods_spec c','a.spec_id=c.id','LEFT'],
        ];

        $list = $this->alias('a')
            ->field($field)
            ->join($join)
            ->where($filter)
            ->order('id DESC')
            ->select()->toArray();
            // ->paginate(2);

        return $list;
    }
}