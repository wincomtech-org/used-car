<?php
namespace app\trade\model;

// use think\Model;
use app\usual\model\UsualModel;

/**
* 订单模型 trade_order
*/
class TradeOrderModel extends UsualModel
{
    public function getLists($filter, $order='', $limit='',$extra=[])
    {
        // 支付插件 ,p.title pay_name
        $field = 'a.*,b.name car_name,b.car_mileage,b.car_license_time,b.shop_price,b.more as car_more,c.user_nickname buyer_nickname,d.user_nickname seller_nickname,e.name city_name';
        $join = [
            ['usual_car b','a.car_id=b.id','LEFT'],
            ['user c','a.buyer_uid=c.id','LEFT'],
            ['user d','a.seller_uid=d.id','LEFT'],
            ['district e','b.city_id=e.id','LEFT'],
            // ['plugin p','a.pay_id=p.name','LEFT']
        ];

        // 筛选条件
        $where = ['a.delete_time' => 0];
        if (!empty($extra)) {
            $where = array_merge($where,$extra);
        }

        // 支付方式
        if (!empty($filter['payId'])) {
            $where['a.pay_id'] = $filter['payId'];
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
        // 买家
        $uname = empty($filter['uname']) ? '' : $filter['uname'];
        if (!empty($uname)) {
            $uid = intval($uname);
            if (empty($uid)) {
                $uid = Db::name('user')->where('user_nickname',$uname)->whereOr('user_login',$uname)->value('id');
                $uid = intval($uid);
            }
            $where['a.buyer_uid'] = $uid;
        }
        // 订单号
        $sn = empty($filter['sn']) ? '' : $filter['sn'];
        if (!empty($sn)) {
            $where['a.order_sn'] = ['like', "%$sn%"];
        }

        // 排序
        // $order = empty($order) ? 'is_top DESC,is_rec DESC,update_time DESC' : $order;

        // 数据量
        // $limit = empty($limit) ? config('pagerset.size') : $limit;

        $series = $this->alias('a')->field($field)
            ->join($join)
            ->where($where)
            ->order('a.id DESC')
            ->paginate(config('pagerset.size'));

        return $series;
    }

    public function getPost($id)
    {
        // $post = $this->get($id)->toArray();
        $field = 'a.*,b.name car_name,c.user_nickname buyer_nickname,d.user_nickname seller_nickname';//,p.title pay_name
        // $where = ['a.id' => $id];
        $join = [
            ['usual_car b','a.car_id=b.id','LEFT'],
            ['user c','a.buyer_uid=c.id','LEFT'],
            ['user d','a.seller_uid=d.id','LEFT'],
            // ['plugin p','a.pay_id=p.name','LEFT']
        ];
        $post = $this->alias('a')
            ->field($field)
            ->join($join)
            ->where('a.id',$id)
            ->find();
        $post['buyer_username'] = $post['buyer_nickname'] ? $post['buyer_nickname'] : $post['buyer_username'];
        $post['seller_username'] = $post['seller_nickname'] ? $post['seller_nickname'] : $post['seller_username'];
        return $post;
    }

    public function getOrderStatus($status='')
    {
        return $this->getStatus($status);
    }
}