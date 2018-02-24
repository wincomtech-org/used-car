<?php
namespace app\insurance\model;

use think\Db;
use app\insurance\model\InsuranceModel;

class InsuranceOrderModel extends InsuranceModel
{
    public function getLists($filter=[], $order='', $limit='',$extra=[])
    {
        $field = 'a.*,b.name insurance_name,c.name car_name,d.user_nickname,d.user_login,d.user_email,d.mobile';
        $where = ['a.delete_time' => 0];
        $join = [
            ['insurance b','a.insurance_id=b.id','LEFT'],
            ['usual_car c','a.car_id=c.id','LEFT'],
            ['user d','a.user_id=d.id','LEFT']
        ];

        if (!empty($extra)) {
            $where = array_merge($where,$extra);
        }

        // 保单状态
        if (!empty($filter['status'])) {
            $where['a.status'] = $filter['status'];
        }
        // 所属保险
        if (!empty($filter['insuranceId'])) {
            $where['a.insurance_id'] = intval($filter['insuranceId']);
        }
        // 所属公司
        if (!empty($filter['compId'])) {
            $where['a.company_id'] = intval($filter['compId']);
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
        // 用户ID
        if (!empty($filter['user_id'])) {
            $where['a.user_id'] = intval($filter['user_id']);
        }
        // 用户
        $uname = empty($filter['uname']) ? '' : $filter['uname'];
        $uid = $this->getUid($uname);
        if (!empty($uid)) {
            $where['a.user_id'] = $uid;
        }
        
        // 车牌号 plateNo
        // 保单号
        $sn = empty($filter['sn']) ? '' : $filter['sn'];
        if (!empty($sn)) {
            $where['a.order_sn'] = ['like', "%$sn%"];
        }

        $limit = $this->limitCom($limit);

        $series = $this->alias('a')->field($field)
            ->join($join)
            ->where($where)
            ->order('a.id DESC')
            ->paginate($limit);

        return $series;
    }

    public function getPost($id)
    {
        // $post = $this->get($id)->toArray();
        $field = 'a.*,b.name insurance_name,c.name car_name,d.user_nickname,d.user_login,d.user_email,d.mobile';
        // $where = ['a.id' => $id];
        $join = [
            ['insurance b','a.insurance_id=b.id','LEFT'],
            ['usual_car c','a.car_id=c.id','LEFT'],
            ['user d','a.user_id=d.id','LEFT']
        ];

        $post = $this->alias('a')
            ->field($field)
            ->join($join)
            ->where('a.id',$id)
            ->find();
        if (!empty($post)) {
            $post = $post->toArray();
        }

        $post['username'] = $this->getUsername($post);

        return $post;
    }

    public function getOrderStatus($status='')
    {
        return $this->getStatus($status,'insurance_order_status');
    }

    // 保单检查 查重、获取数据
    public function checkOrder($condition='',$data=false,$field='id,user_id,plateNo,order_sn,amount,status')
    {
        if ($data===false) {
            return $this->where($condition)->count();
        } elseif ($data===true) {
            return $this->field($field)->where($condition)->find();
        }
    }


}