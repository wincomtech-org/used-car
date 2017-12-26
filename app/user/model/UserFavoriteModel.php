<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2017 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: Powerless < wzxaini9@gmail.com>
// +----------------------------------------------------------------------
namespace app\user\model;

use think\Db;
use think\Model;

class UserFavoriteModel extends Model
{
    protected $type = [
        'more' => 'array',
        'url' => 'array',
    ];
    /**
     * 关联 usual_car表
     * @return $this
     */
    // public function car()
    // {
    //     return $this->belongsTo('usual/UsualCarModel', 'object_id')->setEagerlyType(1);
    // }

    public function favorites()
    {
        $userId        = cmf_get_current_user_id();
        $userQuery     = Db::name("UserFavorite");
        $favorites     = $userQuery->where(['user_id' => $userId])->order('id desc')->paginate(10);
        $data['page']  = $favorites->render();
        $data['lists'] = $favorites->items();
        return $data;
    }

    public function deleteFavorite($id)
    {
        $userId           = cmf_get_current_user_id();
        $userQuery        = Db::name("UserFavorite");
        $where['id']      = $id;
        $where['user_id'] = $userId;
        $data             = $userQuery->where($where)->delete();
        return $data;
    }

    // 收藏
    public function collects($filter=[], $order='a.id desc', $limit=10)
    {
        $userId        = cmf_get_current_user_id();
        // 联表 table_name
        $join = [['usual_car b','a.object_id=b.id'],];
        $field = 'a.*,b.name,b.car_mileage,b.car_license_time,b.shop_price,b.market_price,b.shop_tel,b.more';
        $where = ['a.user_id'=>$userId];
        if (!empty($filter)) {
            $where = array_merge($where,$filter);
        }

        // 获取数据
        $list = $this->alias('a')
              ->field($field)
              ->join($join)
              ->where($where)
              ->order($order)
              // ->select()->toArray();
              ->paginate($limit);
              // ->paginate($limit)->toArray();

        return $list;
    }



}