<?php
namespace app\shop\model;

use think\Model;

/**
* 商品评论区
*/
class ShopEvaluateModel extends Model
{
    protected $type = [
        'evaluate_image' => 'array',
    ];

    public function getEvalList($filter='')
    {
        $where['status'] = 1;

        $list = $this->alias('a')
            ->field('a.id,a.user_id,a.goods_id,a.star,a.description,a.evaluate_image,a.create_time,b.avatar,b.user_nickname,b.user_login,b.mobile')
            ->join('user b','a.user_id=b.id')
            ->where($where)->where($filter)
            ->order('create_time DESC')
            ->paginate(1);
            // ->fetchSql(true)->select();

        return $list;
    }

    // 统计 被除数不能为0
    public function Ecount($filter='')
    {
        $amount = $this->where($filter)->count();
        $good = $this->where($filter)->where('star',1)->count();
        $normal = $this->where($filter)->where('star',0)->count();
        $bad = $this->where($filter)->where('star',-1)->count();

        $percentage['good'] = $amount==0 ? 0 : ceil(($good/$amount)*10000)/100;
        // $percentage['normal'] = round(($normal/$amount)*100,2);
        $percentage['normal'] = $amount==0 ? 0 : floor(($normal/$amount)*10000)/100;
        $percentage['bad'] = $amount==0 ? 0 : floor(($bad/$amount)*10000)/100;

        return ['eval'=>[$amount,$good,$normal,$bad],'per'=>$percentage];
    }

}