<?php
namespace app\insurance\model;

use think\Db;
use app\insurance\model\InsuranceModel;

class InsuranceOrderModel extends InsuranceModel
{
    //自定义初始化
   /* protected function initialize()
    {
        //需要调用`Model`的`initialize`方法
        // parent::initialize();
        //TODO:自定义的初始化
        $this->field = 'a.*,b.name insurance_name,c.name car_name,d.user_login';
        $this->join = [
            ['insurance b','a.insurance_id=b.id','LEFT'],
            ['usual_car c','a.car_id=c.id','LEFT'],
            ['user d','a.user_id=d.id','LEFT']
        ];
    }*/

    public function getLists($filter)
    {
        $field = 'a.*,b.name insurance_name,c.name car_name,d.user_login';
        $where = ['a.delete_time' => 0];
        $join = [
            ['insurance b','a.insurance_id=b.id','LEFT'],
            ['usual_car c','a.car_id=c.id','LEFT'],
            ['user d','a.user_id=d.id','LEFT']
        ];

        // 所属保险
        $insuranceId = empty($filter['insuranceId']) ? 0 : intval($filter['insuranceId']);
        if (!empty($filter['insuranceId'])) {
            $where['a.insurance_id'] = $filter['insuranceId'];
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
        // 用户
        $uname = empty($filter['uname']) ? '' : $filter['uname'];
        if (!empty($uname)) {
            $uid = intval($uname);
            if (empty($uid)) {
                $uid = Db::name('user')->where('user_nickname',$uname)->whereOr('user_login',$uname)->value('id');
                $uid = intval($uid);
            }
            $where['a.user_id'] = $uid;
        }
        // 保单号
        $sn = empty($filter['sn']) ? '' : $filter['sn'];
        if (!empty($sn)) {
            $where['a.order_sn'] = ['like', "%$sn%"];
        }

        $series = $this->alias('a')->field($field)
            ->join($join)
            ->where($where)
            ->order('a.id DESC')
            ->paginate(5);

        return $series;
    }

    public function getPost($id)
    {
        // $post = $this->get($id)->toArray();
        $field = 'a.*,b.name insurance_name,c.name car_name,d.user_login';
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

        return $post;
    }


}