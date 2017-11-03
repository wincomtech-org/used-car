<?php
namespace app\trade\model;

// use think\Model;
use app\usual\model\UsualModel;

/**
* 订单模型 trade_order
*/
class TradeOrderModel extends UsualModel
{
    public function getLists($filter, $isPage = false)
    {
        $field = 'a.*,b.name car_name,c.user_nickname buyer_nickname,d.user_nickname seller_nickname,e.title pay_name';
        $where = ['a.delete_time' => 0];
        $join = [
            ['usual_car b','a.car_id=b.id','LEFT'],
            ['user c','a.buyer_uid=c.id','LEFT'],
            ['user d','a.seller_uid=d.id','LEFT'],
            ['plugin e','a.pay_id=e.name','LEFT']
        ];

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

        $series = $this->alias('a')->field($field)
            ->join($join)
            ->where($where)
            ->order('a.id DESC')
            ->paginate(config('pagerset.pagesize'));

        return $series;
    }

    public function getPost($id)
    {
        // $post = $this->get($id)->toArray();
        $field = 'a.*,b.name car_name,c.user_nickname buyer_nickname,d.user_nickname seller_nickname,e.title pay_name';
        // $where = ['a.id' => $id];
        $join = [
            ['usual_car b','a.car_id=b.id','LEFT'],
            ['user c','a.buyer_uid=c.id','LEFT'],
            ['user d','a.seller_uid=d.id','LEFT'],
            ['plugin e','a.pay_id=e.name','LEFT']
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
        $status = intval($status);
        $order_status = config('trade_order_status');
        $options = '';
        foreach ($order_status as $key => $vo) {
            $options .= '<option value="'.$key.'" '.($status==$key?'selected':'').'>'.$vo.'</option>';
        }

        return $options;
    }
}